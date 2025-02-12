@extends('portal')

@section('content')

<h1>Website Settings</h1>
@if (session('success'))
    <p class="success" role="alert">{{ session('success') }}</p>
@endif

@foreach ($errors->all() as $error)
    <p class="error" role="alert">{{ $error }}</p>
@endforeach

<form method="POST" action="/admin/settings" id="settings">

	@csrf
	@method('PUT')

    <h2>Identity</h2>

    <div class="field">
		<label for="name">Website Name</label>
		<input type="text" name="name" placeholder="Website Name" value="{{ $settings->name ?? '' }}" autofocus>
    </div>

    <div class="field">
		<label for="logo_url">Logo URL</label>
        <div class="input-with-button">
            <input type="text" name="logo_url" placeholder="/example.png" value="{{ $settings->logo_url ?? '' }}">
            <button class="select"><i class="far fa-images"></i></button>
        </div>
    </div>

    <div class="field">
		<label for="meta_description">Metadata Description</label>
		<input type="text" name="meta_description" placeholder="A short description of your website displayed in search results." maxlength="160" value="{{ $settings->meta_description ?? '' }}">
    </div>

    <div class="field">
		<label for="email">Email (Contact Form &amp; Reviews)</label>
		<input type="email" name="email" placeholder="email@example.com" value="{{ $settings->email ?? '' }}">
    </div>

    <h2>Social Media</h2>

    <div class="field">
		<label for="social_email">Email (Display)</label>
		<input type="email" name="social_email" placeholder="me@example.com" value="{{ $settings->social_email ?? '' }}">
    </div>

    <div class="field">
		<label for="social_bandcamp">Bandcamp Username</label>
		<input type="text" name="social_bandcamp" placeholder="username" value="{{ $settings->social_bandcamp ?? '' }}">
    </div>

    <div class="field">
		<label for="social_facebook">Facebook Username</label>
		<input type="text" name="social_facebook" placeholder="username" value="{{ $settings->social_facebook ?? '' }}">
    </div>

    <div class="field">
		<label for="social_instagram">Instagram Username</label>
		<input type="text" name="social_instagram" placeholder="username" value="{{ $settings->social_instagram ?? '' }}">
    </div>

    <div class="field">
		<label for="social_linkedin">Linkedin URL</label>
		<input type="text" name="social_linkedin" placeholder="your-name-123" value="{{ $settings->social_linkedin ?? '' }}">
    </div>

    <div class="field">
		<label for="social_phone">Phone Number</label>
		<input type="text" name="social_phone" placeholder="+1 (234) 567-8901" value="{{ $settings->social_phone ?? '' }}">
    </div>

    <div class="field">
		<label for="social_pinterest">Pinterest Username</label>
		<input type="text" name="social_pinterest" placeholder="username" value="{{ $settings->social_pinterest ?? '' }}">
    </div>

    <div class="field">
		<label for="social_twitter">Twitter Username</label>
		<input type="text" name="social_twitter" placeholder="username" value="{{ $settings->social_twitter ?? '' }}">
    </div>

    <div class="field">
		<label for="social_youtube">Youtube Channel</label>
		<input type="text" name="social_youtube" placeholder="channelname" value="{{ $settings->social_youtube ?? '' }}">
    </div>

    @if (isset($settings->esoteric_social) && $settings->esoteric_social === 1)

    <h2>Esoteric Social Media</h2>

    <div class="field">
		<label for="social_houzz">Houzz Link</label>
		<input type="text" name="social_houzz" placeholder="professionals/12345" value="{{ $settings->social_houzz ?? '' }}">
    </div>

    @endif

    @if (isset($settings->google_analytics) && $settings->google_analytics === 1)

    <h2>Google Analytics</h2>

    <div class="field">
		<label for="tracking_id">Tracking ID</label>
		<input type="text" name="tracking_id" placeholder="UA-1234567-8" maxlength="160" value="{{ $settings->tracking_id ?? '' }}">
    </div>

    @endif

    @if ($settings->google_ads == true)

    <h2>Google Ads</h2>

    <div class="field">
		<label for="google_ads_client">data-ad-client</label>
		<input type="text" name="google_ads_client" placeholder="ca-pub-1234567890987654" maxlength="160" value="{{ $settings->google_ads_client ?? '' }}">
    </div>

    <div class="field">
		<label for="google_ads_slot">data-ad-slot</label>
		<input type="text" name="google_ads_slot" placeholder="1234567890" maxlength="160" value="{{ $settings->google_ads_slot ?? '' }}">
    </div>

    @endif

	<div>
		<button type="submit">Save Settings</button>
	</div>

</form>

<div class="prompts" id="prompts">
    <x-media_prompt />
</div><!-- end #prompts -->

<script>
    addSettingsListeners();
    addGlobalListeners();
</script>

@endsection
