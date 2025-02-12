<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Section;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class WebController extends Controller
{
    public function __construct()
    {
        $this->sections = Section::orderBy('weight', 'ASC')->get();
        $this->reviews = Review::where('approved', true)->orderBy('created_at', 'desc')->get();
        $this->settings = Settings::find(1);

        $url = config('app.url');
        $this->domain = preg_replace('/https?:\/\//i', '', $url);
    }

    public function contactUs(Request $request)
    {

        if (! config('services.recaptcha.key')) {
            request()->validate($request, [
                'name' => 'max:205',
                'email' => 'required|email|max:205',
                'subject' => 'max:205',
                'body' => 'required|max:10000',
            ]);
        } else {
            request()->validate($request, [
                'name' => 'max:205',
                'email' => 'required|email|max:205',
                'subject' => 'max:205',
                'body' => 'required|max:10000',
                'g-recaptcha-response' => 'required|recaptcha',
            ]);
        }

        if (! $this->settings || ! $this->settings->email) {
            return redirect('/')->withErrors(['email' => 'No contact email has been set.']);
        }

        Mail::send(
            'message',
            [
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

    public function submitReview(Request $request)
    {

        if (! config('services.recaptcha.key')) {
            request()->validate($request, [
                'name' => 'required|max:205',
                'review' => 'required|max:10000',
            ]);
        } else {
            request()->validate($request, [
                'name' => 'required|max:205',
                'review' => 'required|max:10000',
                'g-recaptcha-response' => 'required|recaptcha',
            ]);
        }

        $name = Purify::clean(request('name'));

        $review_input = Purify::clean(request('review'));
        $sentences = preg_split('/\r\n|\r|\n/', $review_input);
        $review = '';
        foreach ($sentences as $sentence) {
            if ($sentence == '') {
                continue;
            }
            $paragraph = '<p>' . $sentence . '</p>';
            $review .= $paragraph;
        }

        $id = Str::uuid()->toString();

        Mail::send(
            'submission',
            [
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

        Review::create([
            'id' => $id,
            'name' => $name,
            'review' => $review,
        ]);

        return redirect('/')->with('success', 'Your review is pending approval.');
    }

    public function approveReview($id)
    {

        $review = Review::where('id', $id)->first();

        if ($review === null) {
            abort(404);
        }

        $review->update(['approved' => true]);

        return redirect('/')->with(
            'success',
            'The review was successfully approved! To see it, you may need to refresh the page.'
        );
    }

    public function discardReview($id)
    {

        $review = Review::where('id', $id)->first();

        if ($review === null) {
            abort(404);
        }

        $review->delete();

        return redirect('/')->with('success', 'The review was successfully discarded.');
    }
}
