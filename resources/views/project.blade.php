@extends('layout')

@section('content')

<div class="@auth editing @endauth project container" id="project-{{ $project->id ?? '' }}">

    @auth
    <div class="actions project-actions">

        <form method="POST" action="/admin/project/{{ $project->id ?? '' }}" id="discard-project">
            @csrf
            @method('DELETE')
            <button class="discard" type="submit">
                <i class="fas fa-trash"></i>
            </button>
        </form>

        <form method="POST" action="/admin/project/{{ $project->id ?? '' }}" class="update-project">
            @csrf
            @method('PUT')

            <div>
                <label for="id">Project ID:</label>
                <input name="id" type="text" value="{{ $project->id }}" readonly>
            </div>

            <div class="meta-description">
                <label for="meta_description">Metadata Description:</label>
                <input name="meta_description" type="text" value="{{ $project->meta_description ?? '' }}" maxlength="160" placeholder="A short description of the project for search results.">
            </div>

            <div>
                <label for="featured_image_id">Featured image:</label>
                <input name="featured_image_id" type="number" value="{{ $project->featured_image_id ?? '' }}" maxlength="120">
                <a class="button select" title="select media" href="#"><i class="far fa-images"></i></a>
            </div>

            <div>
                <label for="slug">Project link:</label>
                <input name="slug" type="text" value="{{ $project->slug ?? '' }}" maxlength="50" required placeholder="new-project">
            </div>

            <input name="title" type="text" value="{{ $project->title ?? '' }}"  maxlength="120">
            <textarea name="body" id="project-{{ $project->id ?? '' }}-to-send" class="to-send" maxlength="10000">{!! Purify::clean($project->body ?? '' ) !!}</textarea>

            <button class="save" type="submit" title="save">
                <i class="fas fa-check"></i>
            </button>

        </form>

    </div><!-- end .actions -->
    @endauth

    <div class="inner">
        <div class="content">

            <x-slideshow :media="$media" />
            <x-gallery :media="$media" />

            @auth
            <x-upload_media :id="$project->id" />
            @endauth

            <div class="body">
                <div class="inside">

                    <h1 class="title page-title">{{ $project->title ?? '' }}</h1>

                    @if (Auth::check())
                    <div id="project-{{ $project->id ?? '' }}-pell" class="pell-editor"></div>
                    @else
                    {!! Purify::clean($project->body ?? '') !!}
                    @endif

                    <div class="project-navigation">
                        <a class="arrow prev" href="/project/{{ $project->slug ?? '' }}/prev">
                            <i class="fas fa-chevron-left"></i>&nbsp; Previous Project
                        </a>
                        <a class="arrow next" href="/project/{{ $project->slug ?? '' }}/next">
                            Next Project &nbsp;<i class="fas fa-chevron-right"></i>
                        </a>
                    </div>

                </div>
            </div>

            @auth
            <script>
            (function() {
                const container = document.getElementById('project-{{ $project->id ?? '' }}');
                buildEditor(container);
            })();
            </script>
            @endauth

        </div><!-- end .content -->

    </div><!-- end .inner -->
</div><!-- end #project -->

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
    </div><!-- TODO discard project prompt -->

    <x-pell_prompts />

    <x-media_prompt />

    <x-expiration_prompt />

</div>
<script>
addProjectListeners();
</script>
@endauth

@endsection
