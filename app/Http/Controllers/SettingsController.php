<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stevebauman\Purify\Facades\Purify;

class SettingsController extends Controller
{
    public function __construct()
    {

        $this->settings = Settings::find(1);
    }

    public function showSettingsForm()
    {
        return view('settings', [
            'settings' => $this->settings,
            'classes' => 'page',
        ]);
    }

    public function updateSettings(Request $request)
    {
        request()->validate([
            'name' => 'max:160|nullable',
            'logo_url' => 'max:160|nullable',
            'meta_description' => 'max:160|nullable',
            'email' => 'email|max:160|nullable',
            'google_ads_client' => 'max:40|nullable',
            'google_ads_slot' => 'max:20|nullable',
            'tracking_id' => 'max:20|nullable',
            'social_bandcamp' => 'max:100|nullable',
            'social_email' => 'email|max:100|nullable',
            'social_facebook' => 'max:100|nullable',
            'social_houzz' => 'max:100|nullable',
            'social_instagram' => 'max:100|nullable',
            'social_linkedin' => 'max:100|nullable',
            'social_pinterest' => 'max:100|nullable',
            'social_phone' => 'max:100|nullable',
            'social_twitter' => 'max:100|nullable',
            'social_youtube' => 'max:100|nullable',
        ]);

        $settings = Settings::find(1);

        if (! $settings) {
            $settings = new Settings;
            $settings->save();
        }
        Log::info($request);

        $settings->update([
            'name' => Purify::clean($request->input('name')),
            'logo_url' => Purify::clean($request->input('logo_url')),
            'meta_description' => Purify::clean($request->input('meta_description')),
            'email' => Purify::clean($request->input('email')),
            'google_ads_client' => Purify::clean($request->input('google_ads_client')),
            'google_ads_slot' => Purify::clean($request->input('google_ads_slot')),
            'tracking_id' => Purify::clean($request->input('tracking_id')),
            'social_bandcamp' => Purify::clean($request->input('social_bandcamp')),
            'social_email' => Purify::clean($request->input('social_email')),
            'social_facebook' => Purify::clean($request->input('social_facebook')),
            'social_houzz' => Purify::clean($request->input('social_houzz')),
            'social_instagram' => $request->input('social_instagram'),
            'social_linkedin' => Purify::clean($request->input('social_linkedin')),
            'social_pinterest' => Purify::clean($request->input('social_pinterest')),
            'social_phone' => Purify::clean($request->input('social_phone')),
            'social_twitter' => Purify::clean($request->input('social_twitter')),
            'social_youtube' => $request->input('social_youtube'),
        ]);

        return redirect('/admin/settings')->with('success', 'Your website settings were successfully updated.');
    }
    //
}
