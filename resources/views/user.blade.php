@extends('portal')

@section('content')

<h1>User Information</h1>
@if (session('success'))
    <p class="success" role="alert">{{ session('success') }}</p>
@endif

@foreach ($errors->all() as $error)
    <p class="error" role="alert">{{ $error }}</p>
@endforeach

<form method="POST" action="/admin/user">

	@csrf
	@method('PUT')

    <div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" placeholder="your_username" value="{{ isset($user->username) ? $user->username : '' }}" required autofocus>
    </div>
    <div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" placeholder="Your Name" value="{{ isset($user->name) ? $user->name : '' }}" maxlength="160" required>
    </div>
    <div class="field">
		<label for="email">Email</label>
		<input type="email" name="email" placeholder="email@example.com" value="{{ isset($user->email) ? $user->email : '' }}" >
    </div>
    <div class="field">
		<label for="password">New Password</label>
		<input type="password" name="password" placeholder="Only fill this field if you want to update your password." maxlength="160">
    </div>
	<div>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>

</form>

<div class="prompts" id="prompts">
    <x-media_prompt />
</div><!-- end #prompts -->

<script>
    addPromptHandlers();
    const select = document.getElementById('settings').querySelector('.select');
    select.addEventListener('click', (e) => {
        e.preventDefault();
        showMediaLibrary();
    });
</script>

@endsection
