@extends('portal')

@section('content')
<h1>Reset Password</h1>
<form method="POST" action="/password/reset">
    @csrf

    @error('email')
        <p class="error" role="alert">
            {{ $message }}
        </p>
    @enderror
    @error('password')
        <p class="error" role="alert">
            {{ $message }}
        </p>
    @enderror
    <input type="hidden" name="token" value="{{ $token }}">

        <label for="email" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('E-Mail Address') }}</label>

        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="email"  value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>


        <label for="password" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('Password') }}</label>

        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="new-password">


        <label for="password-confirm" class="col-md-4 col-form-label text-md-right" style="display:none;">{{ __('Confirm Password') }}</label>

        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="confirm password" required autocomplete="new-password">
    <div class="">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
