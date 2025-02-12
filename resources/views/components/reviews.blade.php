@foreach ($reviews as $review)
    <div class="review">
        <blockquote>{!! Purify::clean($review->review); !!}</blockquote>
        <p class="author">&mdash; <i>{{ $review->name }}</i></p>
    </div>
@endforeach
