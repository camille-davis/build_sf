<footer id="footer" class="@auth editing @endauth container">

    @auth
        <div class="actions">
            <form method="POST" action="/admin/block">
                @csrf
                <input name="location" type="text" value="footer" />
                <button type="submit">
                    <i class="fa fa-plus"></i> &nbsp;Column
                </button>
            </form>

            <form method="POST" action="/admin/blocks" class="update-blocks">
                @method('PUT')
                @csrf
                <button class="save" type="submit" title="save">
                    <i class="fas fa-check"></i>
                </button>

                <input name="block_ids" type="text" value="{{ $blocks->pluck('id')->implode(',') ?? '' }}" />

                @foreach ($blocks as $block)
                    <input name="block_{{ $block->id ?? '' }}_type" type="text" value="{{ $block->type ?? '' }}" />
                    <textarea name="block_{{ $block->id ?? '' }}_body" class="to-send" maxlength="10000" id="block-{{ $block->id ?? '' }}-to-send">
                        {!! Purify::clean($block->body ?? '') !!}
                    </textarea>
                @endforeach
            </form>
        </div>
    @endauth

    <div class="inner">
        <div class="content">
            @foreach ($blocks as $block)
                <x-block :block="$block" :settings="$settings" />
            @endforeach
        </div><!-- end .content -->
    </div><!-- end .inner -->

    @auth
        <script>
            deactivate(document.getElementById('footer'));
            addGlobalListeners();
            addPellListeners();
        </script>
    @endauth
</footer>
