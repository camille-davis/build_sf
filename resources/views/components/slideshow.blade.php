<div class="slider">

    @if (isset($media) && isset($media[0]))
        @foreach ($media as $item)
        <img id="image-{{ $item->id ?? '' }}" class="slide" src="/storage/media/{{ $item->filename ?? '' }}" lazysrc="/storage/media/{{ $item->filename ?? '' }}" alt="{{ $item->alt ?? '' }}"/>
        <script>
        document.getElementById('image-{{ $item->id ?? '' }}').src = "";
        </script>
        @endforeach
    @endif

</div>
