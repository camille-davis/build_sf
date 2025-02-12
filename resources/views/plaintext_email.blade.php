{{-- Greeting --}}
@if (! empty($greeting))
{{ $greeting }}
@elseif ($level === 'error')
@lang('Whoops!')
@else
@lang('Hello!')
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

<br /><br />

{{-- Action Button --}}
@isset($actionText)
<a href="{{ $actionUrl }}">{{ $actionText ?? $actionUrl }}</a>
@endisset

<br /><br />

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

<br /><br />

{{-- Subcopy --}}
@isset($actionText)
@lang(
    "If you’re having trouble clicking the \":actionText\" link, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
)

<a href="{{ $actionUrl }}">{{ $displayableActionUrl }}</a>
@endisset
