<ul class="projects-list gallery">
@foreach ($projects as $project)

    @if (isset($project->featured_image_filename))
    <?php
        $rawFilename = explode('.', $project->featured_image_filename);
        $thumbFilename = '/storage/media/' . $rawFilename[0] . '_thumb.' . $rawFilename[1];
    ?>
    @endif

    <li id="project-{{ $project->id ?? '' }}" draggable="false" style="background-image: url('{{ $thumbFilename ?? '' }}');">

        <a href="/project/{{ $project->slug ?? '' }}" class="project-link" draggable="false">
            @if (isset($project->featured_image_filename))
            <img class="project-thumbnail" src="{{ $thumbFilename ?? '' }}" alt="" />
            @endif
            <div class="project-label">{{ $project->title ?? '' }}</div>
        </a>
        @auth
        <div class="actions">
            <a class="move button" title="Move project" href="#" draggable="false">
                <i class="fas fa-arrows-alt"></i>
            </a>
        </div>
        @endauth
    </li>
@endforeach
</ul>
