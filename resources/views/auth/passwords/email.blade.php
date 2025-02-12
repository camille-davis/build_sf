@extends('portal')

@section('content')

<h1>Send Password Reset Link</h1>

@if (session('status'))
	<p class="alert success" role="alert">
	{{ session('status') }}
	</p>
@endif

<form method="POST" action="/password/email" id="password-form">
	@csrf

		@error('email')
			<p class="error" role="alert">
				{{ $message }}
			</p>
		@enderror

		<label for="email" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('E-Mail Address') }}</label>
		<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="email" value="" required autocomplete="email" autofocus>

	@if (config('services.recaptcha.key'))
		<div class="g-recaptcha"
			data-sitekey="{{ config('services.recaptcha.key') }}">
		</div>
        <script>
            addCaptchaError(document.getElementById('password-form'));
        </script>
	@endif

	<div class="form-group row mb-0">
		<button type="submit" class="btn btn-primary">Send</button>
	</div>
</form>

@endsection
