<!DOCTYPE html>
<html>
	<head>


        <title>{{ $settings->name ?? '' }}@if ((isset($page) && $page->homepage != 1) || (isset($project))) | {{ $page->title ?? $project->title ?? '' }}@endif</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">

        <meta name="description" content="{{ $page->meta_description ?? $project->meta_description ?? $settings->meta_description ?? '' }}">

		<link rel=stylesheet href="/css/common.css">
        @if (isset($settings->theme) && $settings->theme === 'dark')
        <link rel=stylesheet href="/css/dark.css">
        @endif
        @if (isset($settings->layout) && $settings->layout === 'nav_left')
        <link rel=stylesheet href="/css/nav_left.css">
        @endif
		<link rel=stylesheet href="/css/style.css">

        <script src="/js/functions.js"></script>

        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script src="https://kit.fontawesome.com/4a20555d6f.js" crossorigin="anonymous"></script>

		@auth
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script src="/js/admin.js"></script>
        <script src="https://unpkg.com/pell"></script>
        @endauth

        @if (isset($settings->google_analytics)
        && $settings->google_analytics == true)
        <x-gtag :settings="$settings" />
        @endif

        @if (isset($settings->google_ads)
        && $settings->google_ads == true)
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings->google_ads_client ?? '' }}"
     crossorigin="anonymous"></script>
        @endif

	</head>

	<body class="@if (isset($page->id))page-{{ $page->id }}@endif">

        <x-nav :settings="$settings" :items="$navLinks" />

		<main>

            <div id="alerts">
                <div class="inner">
                    <div class="content">

                    @if (session('success'))
                    <p class="success" role="alert">
                        {{ session('success') }}
                    </p>
                    @endif

                    @if (isset($errors) && $errors->any())
                    {!! implode('', $errors->all('<p class="error" role="alert">:message</p>')) !!}
                    @endif

                    </div>
                </div><!-- end .inner -->
            </div><!-- end #alerts -->

			@yield('content')

            <x-footer :settings="$settings" :pageid="$page->id ?? null" :blocks="$footerBlocks"/>

		</main>

    @auth
    <x-user :settings="$settings" />
    <script>
    addLayoutListeners();

    </script>
    @endauth

	<script>

    window.scrollTo(0, 0);

    dropdownNav();

    @if (isset($settings->transparent_nav) && $settings->transparent_nav !== 0)
    transparentNav();
    @endif

    activateSliders();
    activateCollapsible();

	</script>

    @if (isset($settings->custom_js) && $settings->custom_js == true)
    <script src="/js/custom.js"></script>
    @endif

	</body>

</html>
