<!DOCTYPE html>
<html>

  <head>

    <title>{{ isset($settings->name) ? $settings->name : '' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <link rel=stylesheet href="/css/common.css">

    @if ((isset($settings->theme)) && ($settings->theme === 'dark'))
    <link rel=stylesheet href="/css/dark.css">
    @endif

    <link rel=stylesheet href="/css/style.css">

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="/js/functions.js"></script>

    @auth
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="/js/admin.js"></script>
    <script src="https://kit.fontawesome.com/4a20555d6f.js" crossorigin="anonymous"></script>
    @endauth


  </head>

  <body class="portal {{ isset($classes) ? $classes : '' }}">

    <main>
        <div class="sheet">
            @yield('content')
        </div>
    </main>

    @auth
    <x-user :settings="$settings" />
    @endauth

  </body><!-- end .portal -->

</html>
