@extends('layout')

@section('content')

@if (isset($page) && $page)

<div class="@auth editing @endauth page-header container" id="page">

    @auth
    <div class="actions">

        <form method="POST" action="/admin/page/{{ $page->id ?? '' }}" id="discard-page"> @csrf @method('DELETE')
            <button class="discard" type="submit">
                <i class="fas fa-trash"></i>
            </button>
        </form>

        <form method="POST" action="/admin/section"> @csrf
            <input name="page_id" type="number" value="{{ $page->id ?? '' }}" />
            <button type="submit">
                <i class="fa fa-plus"></i> &nbsp;Section
            </button>
        </form>

        <form method="POST" action="/admin/page/{{ $page->id ?? '' }}" class="update-page"> @csrf @method('PUT')

            <div class="meta-description">
                <label for="meta_description">Metadata Description:</label>
                <input name="meta_description" type="text" value="{{ $page->meta_description ?? '' }}" maxlength="160" placeholder="A short description of the page for search results.">
            </div>

            <div>
                <label for="slug">Page link:</label>
                <input name="slug" type="text" value="{{ $page->slug ?? '' }}" maxlength="50" required placeholder="new-page">
            </div>

            <button class="save" type="submit" title="save">
                <i class="fas fa-check"></i>
            </button>

            <input name="title" type="text" value="{{ $page->title ?? '' }}" required maxlength="120">

        </form>

    </div><!-- end .actions -->
    @endauth

    <div class="inner">
        <div class="content">
            <h1 class="title page-title">{{ $page->title ?? '' }}</h1>
        </div>
    </div><!-- end .inner -->

</div><!-- end .container -->

@auth
<script>
    deactivate(document.getElementById('page'));
</script>
@endauth

@endif

<div class="sections">
    @if ($sections)
        @foreach ($sections as $section)
        <x-section :section="$section" :settings="$settings" :projects="$projects" :reviews="$reviews" />
        @endforeach
    @endif
</div>

@auth
<div class="prompts" id="prompts">

    <div class="prompt-container" id="discard-page-prompt">
        <div class="prompt">
            <button class="close" title="Close">
                <i class="fas fa-times"></i>
            </button>
            <p>Are you sure you want to discard this page and all of its contents?</p>
            <button class="confirm">Confirm</button>
        </div>
    </div>

    <div class="prompt-container" id="discard-section-prompt">
        <div class="prompt">
            <button class="close" title="Close">
                <i class="fas fa-times"></i>
            </button>
            <p>Are you sure you want to discard this section?</p>
            <button class="confirm">Confirm</button>
        </div>
    </div>

    <x-pell_prompts />

    <x-media_prompt />

    <x-expiration_prompt />

    <script>
    addPageListeners();
    </script>
</div>
@endauth

@endsection
