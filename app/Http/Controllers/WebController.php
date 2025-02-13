<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class WebController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
        $this->domain = preg_replace('/https?:\/\//i', '', config('app.url'));
    }

    // Contact form functionality.
    public function contactUs()
    {
        // Check if an email address exists to receive the message.
        if (! $this->settings || ! $this->settings->email) {
            return redirect('/')->withErrors(['email' => 'No contact email has been set.']);
        }

        // Set validation rules.
        $rules = [
            'name' => 'max:205',
            'email' => 'required|email|max:205',
            'subject' => 'max:205',
            'body' => 'required|max:10000',
        ];

        // Add Captcha if enabled.
        if (config('services.recaptcha.key')) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        // Validate the request.
        request()->validate($rules);

        // Send the message.
        Mail::send(
            'message', [
                'name' => Purify::clean(request('name')),
                'email' => Purify::clean(request('email')),
                'subject' => Purify::clean(request('subject')),
                'body' => Purify::clean(request('body')),
            ],
            function ($message) {
                $message->from('subtle.noreply@gmail.com');
                $message->to($this->settings->email)
                    ->replyTo(Purify::clean(request('email')))
                    ->subject('New Message via ' . $this->domain);
            }
        );

        return back()->with('success', 'Thanks for contacting us!');
    }

    public function submitReview()
    {
        // Set validation rules.
        $rules = [
            'name' => 'required|max:205',
            'review' => 'required|max:10000',
        ];

        // Add Captcha if enabled.
        if (config('services.recaptcha.key')) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        // Validate the request.
        request()->validate($rules);

        // Turn line breaks into paragraphs.
        $paragraphs = preg_split('/\r\n|\r|\n/', Purify::clean(request('review')));
        $review = '';
        foreach ($paragraphs as $paragraph) {
            if ($paragraph == '') {
                continue;
            }
            $processed = '<p>' . $paragraph . '</p>';
            $review .= $processed;
        }

        // Process additional submission data.
        $name = Purify::clean(request('name'));
        $id = Str::uuid()->toString();

        // Send new review notification.
        Mail::send(
            'submission', [
                'id' => $id,
                'name' => $name,
                'review' => $review,
                'domain' => $this->domain,
            ],
            function ($message) {
                $message->from('subtle.noreply@gmail.com');
                $message->to($this->settings->email)->subject('New Review Submission via ' . $this->domain);
            }
        );

        // Save review data.
        Review::create([
            'id' => $id,
            'name' => $name,
            'review' => $review,
        ]);

        return redirect('/')->with('success', 'Your review is pending approval.');
    }

    public function approveReview($id)
    {
        // Find review for the given ID.
        $review = Review::where('id', $id)->first();
        if ($review === null) {
            abort(404);
        }

        // Mark review as approved.
        $review->update(['approved' => true]);

        return redirect('/')->with(
            'success',
            'The review was successfully approved! To see it, you may need to refresh the page.'
        );
    }

    public function discardReview($id)
    {
        // Find review for the given ID.
        $review = Review::where('id', $id)->first();
        if ($review === null) {
            abort(404);
        }

        // Delete it.
        $review->delete();
        return redirect('/')->with('success', 'The review was successfully discarded.');
    }
}
