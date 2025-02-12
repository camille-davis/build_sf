<div class="section {{ $section->type ?? '' }} @auth editing @endauth container" id="section-{{ $section->id ?? '' }}" type="{{ $section->type ?? '' }}">

    <div class="target" id="{{ $section->slug ?? '' }}"></div>

    @auth
    <div class="actions">

        <form method="POST" action="/admin/section/{{ $section->id ?? '' }}/up"> @csrf @method('PATCH')
            <button type="submit" title="Move section up" class="up">
                <i class="fas fa-arrow-up"></i>
            </button>
        </form>

        <form method="POST" action="/admin/section/{{ $section->id ?? '' }}/down"> @csrf @method('PATCH')
            <button type="submit" title="Move section down" class="down">
                <i class="fas fa-arrow-down"></i>
            </button>
        </form>

        <form method="POST" action="/admin/section/{{ $section->id ?? '' }}" class="discard-section"> @csrf @method('DELETE')
            <button type="submit" title="Discard section" class="discard">
                <i class="fas fa-trash"></i>
            </button>
        </form>

        <form method="POST" action="/admin/section/{{ $section->id ?? '' }}" class="update-section"> @csrf @method('PUT')

            <div>
                <label for="type">Section type:</label>
                <select name="type">
                    <option value="basic" {{ $section->type === 'basic' ? 'selected' : '' }}>Basic</option>
                    <option value="sheet" {{ $section->type === 'sheet' ? 'selected' : '' }}>Sheet</option>
                    <option value="contact" {{ $section->type === 'contact' ? 'selected' : '' }}>Contact</option>
                    <option value="feature" {{ $section->type === 'feature' ? 'selected' : '' }}>Feature</option>
                    <option value="projects" {{ $section->type === 'projects' ? 'selected' : '' }}>Projects</option>
                    <option value="reviews" {{ $section->type === 'reviews' ? 'selected' : '' }}>Reviews</option>
                    <option value="slideshow" {{ $section->type === 'slideshow' ? 'selected' : '' }}>Slideshow</option>
                    <option value="twitter_feed" {{ $section->type === 'twitter_feed' ? 'selected' : '' }}>Twitter Feed</option>
                </select>
            </div>

            @if ($section->type === 'slideshow')
            <div>
                <label for="image_ids">Image IDs:</label>
                <input name="image_ids" value="{{ $section->image_ids ?? '' }}" maxlength="120" placeholder="0 1 2 3" >
                <a class="button select" title="select media" href="#"><i class="far fa-images"></i></a>
            </div>
            @endif

            <div>
                <label for="slug">Section link:</label>
                <input name="slug" value="{{ $section->slug ?? '' }}" maxlength="50" required placeholder="section-url" >
            </div>

            <button class="save" type="submit" title="save">
                <i class="fas fa-check"></i>
            </button>
            <input name="title" value="{{ $section->title ?? '' }}" maxlength="120" >
            <textarea name="body" id="section-{{ $section->id ?? '' }}-to-send" class="to-send" maxlength="10000">{!! Purify::clean($section->body ?? '') !!}</textarea>

        </form>

    </div><!-- end .actions -->
    @endauth

    <div class="inner">

        <div class="content">

            @if (isset($section->type) && ($section->type === 'contact' || $section->type === 'sheet'))
            <div class="sheet">
            @endif

            <h2 class="title section-title">{{ $section->title ?? '' }}</h2>

            <div class="body {{ (isset($section->collapsible_body) && $section->collapsible_body == 1) ? 'collapsible' : '' }}">
                <div class="inside">
                    @if (Auth::check())
                    <div id="section-{{ $section->id ?? '' }}-pell" class="pell-editor"></div>
                    @else
                    {!! Purify::clean($section->body ?? '') !!}
                    @endif
                </div>
            </div>

            @switch ($section->type ?? '')

                @case ('contact')
                <x-contact :settings="$settings" />
                </div><!-- end .sheet -->
                @break

                @case ('sheet')
                </div><!-- end .sheet -->
                @break

                @case ('projects')
                <x-projects :projects="$projects" />
                @break

                @case ('reviews')
                <x-reviews :reviews="$reviews ?? '' " />
                <x-submit_review />
                @break

                @case ('slideshow')
                <x-slideshow :media="$section->featured_images ?? ''" />
                @break

                @case ('twitter_feed')
                <x-twitter_feed :settings="$settings" />
                @break

            @endswitch

            @if (isset($settings->google_ads) && $settings->google_ads == true)
            <x-advertisement :settings="$settings"/>
            @endif

            @auth
            <script>
            (function() {
                const container = document.getElementById('section-{{ $section->id ?? '' }}');
                buildEditor(container);
                addSectionListeners(container);
            })();
            </script>
            @endauth

        </div><!-- end .content -->
    </div><!-- end .inner -->
</div><!-- end .section -->
