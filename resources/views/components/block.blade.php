<div class="block" id="block-{{ $block->id ?? '' }}">

    @auth
    <div class="actions">
        <!--<form method="POST" action="/admin/section/{{ $section->id ?? '' }}/up">
            @csrf
            @method('PATCH')
            <button type="submit" title="Move section left">
                <i class="fas fa-arrow-left"></i>
            </button>
        </form>

        <form method="POST" action="/admin/section/{{ $section->id ?? '' }}/down">
            @csrf
            @method('PATCH')
            <button type="submit" title="Move section">
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>-->

        <form method="POST" action="/admin/block/{{ $block->id ?? '' }}" class="discard-block">
            @csrf
            @method('DELETE')
            <input name="current_page" type="number" value="{{ $pageid ?? '' }}" readonly />
            <button type="submit" class="discard">
                <i class="fas fa-trash"></i>
            </button>
        </form>

    </div>

    <div class="pell-editor" id="block-{{ $block->id ?? '' }}-pell"></div>

    <script>
    (function() {
        const container = document.getElementById('block-{{ $block->id ?? '' }}');
        buildPell(container);
    })();
    </script>

    @endauth

    @if (!Auth::check())
    {!! Purify::clean($block->body ?? '') !!}
    @endif

    @if ($block->type == "sendinblue")
        <x-sendinblue_form :settings="$settings" />
    @endif

</div><!-- end .block -->
