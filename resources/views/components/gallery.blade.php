<ul class="gallery">
    @foreach ($media as $item)
    <li>
        <a class="media-link" href="/storage/media/{{ $item->filename ?? '' }}" title="View full size">
            <?php $rawFilename = explode('.', $item->filename) ?>
            <img id="image-{{ $item->id ?? '' }}-thumb" src="/storage/media/{{ $rawFilename[0] . '_thumb.' . $rawFilename[1] ?? '' }}" alt="{{ $item->alt ?? '' }}" project_id="{{ $item->project_id ?? '' }}" />
        </a>
        @auth
        <div class="actions">
            <form class="delete-media" method="POST" action="/admin/media/{{ $item->id }}">
                @csrf
                @method('delete')

                @if (isset($currentPage))
                <input name="current_page" type="text" value="{{ $currentPage }}" readonly />
                @endif

                <button type="submit" class="delete"><i class="fas fa-trash-alt"></i></button>
            </form>
            <a class="edit button" title="Edit media attributes" href="#">
                <i class="fas fa-pencil-alt"></i>
            </a>
        </div>
        @endauth
    </li>
    @endforeach
</ul>
