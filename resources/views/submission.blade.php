<p>You've received a review submission from {{ $name }}!</p>
<p><i>
{!! Purify::clean($review); !!}
</i></p>
<p>Approve review: <a href="https://{{ $domain }}/review/approve/{{ $id }}">https://{{ $domain }}/review/approve/{{ $id }}</a></p>
<p>Discard review: <a href="https://{{ $domain }}/review/discard/{{ $id }}">https://{{ $domain }}/review/discard/{{ $id }}</p>

