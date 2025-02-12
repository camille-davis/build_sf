@extends('portal')

@section('content')

<h1>Login</h1>

<form method="POST" action="/login" id="login-form">

	@csrf

	@error('username')
		<p class="error" role="alert">
			{{ $message }}
		</p>
	@enderror

		<label for="username" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('E-Mail Address') }}</label>
		<input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="username" value="" required autocomplete="username" autofocus>

		<label for="password" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('Password') }}</label>
		<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" value="" required autocomplete="current-password">

    @if (config('services.recaptcha.key'))
        <div style="margin: auto;" class="g-recaptcha"
            data-sitekey="{{ config('services.recaptcha.key') }}">
        </div>
        <script>
            addCaptchaError(document.getElementById('login-form'));
        </script>
    @endif

	<div>
		<button type="submit" class="btn btn-primary">Login</button>
	</div>

	<div class="forgot">
		@if (Route::has('password.request'))
			<a class="btn btn-link" href="/password/reset">
				{{ __('Forgot Your Password?') }}
			</a>
		@endif
	</div>

</form>

@endsection
