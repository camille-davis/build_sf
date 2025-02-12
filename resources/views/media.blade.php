@extends('portal')

@section('content')

<h1>Media</h1>

<h2>Add Media</h2>
@if (session('success'))
    <p class="alert success">{{ session('success') }}</p>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p class="alert error">{{ $error }}</p>
    @endforeach
@endif

<x-upload_media />

<h2>Media Library</h2>

@if (isset($media))
<x-gallery :media="$media" currentPage="media"/>
@endif

<x-expiration_prompt />
<x-update_media_prompt :settings="$settings" />
<script>
    addGlobalListeners();
    addMediaLibraryListeners();
</script>

@endsection
