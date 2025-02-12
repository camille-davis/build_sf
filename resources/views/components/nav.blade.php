<nav id="nav" class="@auth editing @endauth container">

    @auth
    <div class="actions">

        <form method="POST" action="/admin/page/weights" class="update-menu-weights">
            @csrf
            @method('PATCH')

            <input type="text" name="item_ids" value="@foreach ($items as $item){{ $item->id ?? '' }} @endforeach" />
            <button class="save" type="submit" title="save">
                <i class="fas fa-check"></i>
            </button>
        </form>

    </div><!-- end .actions -->
    <script>
    deactivate(document.getElementById('nav'));
    </script>
    @endauth

    <div class="inner">

        <h1 id="logo">
            <a href="{{ ($settings->nav_type == 'pages') ? '/' : '#' }}">
                @if ($settings->logo_url != null)
                <img src="{{ $settings->logo_url }}" alt="{{ $settings->name ?? '' }}" />
                @else
                {{ $settings->name ?? '' }}
                @endif
            </a>
        </h1>

        <div id="toggle">
            <button class="hamburger hamburger--squeeze" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>

        <ul id="links">

            @if ($settings->nav_type == 'pages')
                @foreach ($items as $item)
                <li id="link-page-{{ $item->id ?? '' }}">
                    <a href="/{{ $item->slug ?? '' }}">{{ $item->title ?? '' }}</a>
                    @auth
                    <div class="actions">
                        <button class="move button" title="Move menu item" href="#" draggable="false">
                            <i class="fas fa-arrows-alt"></i>
                        </button>
                    </div>
                    @endauth
                </li>
                @endforeach
            @else
                @foreach ($items as $item)
                <li id="link-section-{{ $item->id ?? '' }}">
                    <a href="#{{ $item->slug ?? '' }}">{{ $item->title ?? '' }}</a>
                </li>
                @endforeach
            @endif

        </ul><!-- end #links -->

        <ul id="social">

            @if ($settings->show_social_in_nav == 1)

                @if ($settings->social_bandcamp != '')
                    <li>
                        <a href="https://{{ $settings->social_bandcamp ?? '' }}.bandcamp.com" target="_blank"><i class="fab fa-bandcamp"></i></a>
                    </li>
                @endif
                @if ($settings->social_email != '')
                    <li>
                        <a href="mailto:{{ $settings->social_email ?? '' }}" target="_blank"><i class="fas fa-envelope"></i></a>
                    </li>
                @endif
                @if ($settings->social_facebook != '')
                    <li>
                        <a href="https://facebook.com/{{ $settings->social_facebook ?? '' }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    </li>
                @endif
                @if ($settings->social_houzz != '')
                    <li>
                        <a href="https://houzz.com/{{ $settings->social_houzz ?? '' }}" target="_blank"><i class="fab fa-houzz"></i></a>
                    </li>
                @endif
                @if ($settings->social_instagram != '')
                    <li>
                        <a href="https://instagram.com/{{ $settings->social_instagram ?? '' }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    </li>
                @endif
                @if ($settings->social_linkedin != '')
                    <li>
                        <a href="https://linkedin.com/in/{{ $settings->social_linkedin ?? '' }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </li>
                @endif
                @if ($settings->social_phone != '')
                    <li>
                        <a href="tel:{{ $settings->social_phone ?? '' }}" target="_blank"><i class="fas fa-phone"></i></a>
                    </li>
                @endif
                @if ($settings->social_pinterest != '')
                    <li>
                        <a href="https://pinterest.com/{{ $settings->social_pinterest ?? '' }}" target="_blank"><i class="fab fa-pinterest-p"></i></a>
                    </li>
                @endif
                @if ($settings->social_twitter != '')
                    <li>
                        <a href="https://twitter.com/{{ $settings->twitter ?? '' }}" target="_blank"><i class="fab fa-twitter"></i></a>
                    </li>
                @endif
                @if ($settings->social_youtube != '')
                    <li>
                        <a href="https://youtube.com/{{ $settings->youtube ?? '' }}" target="_blank"><i class="fab fa-youtube"></i></a>
                    </li>
                @endif

            @endif

        </ul><!-- end #social -->

    </div><!-- end .inner -->
</nav>
