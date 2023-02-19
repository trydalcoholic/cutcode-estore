<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', env('APP_NAME'))</title>
        @vite([
            'resources/css/app.css',
            'resources/sass/main.sass',
            'resources/js/app.js'
        ])
    </head>
    <body class="antialiased">
        <main class="py-16 lg:py-20">
            <div class="container">
                @include('shared.flash')

                @yield('content')
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    </body>
</html>
