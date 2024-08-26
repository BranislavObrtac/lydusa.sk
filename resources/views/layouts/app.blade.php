<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.particles._head')
</head>
    <body>
        @include('layouts.particles._navbar')

            <div id="app">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>

        @include('layouts.particles._footer')

        @yield('extra-js')
        <link rel="stylesheet" href="{{ asset('css/purecookie.css') }}"/>
        <script src="{{ asset('js/purecookie.js') }}"></script>
    </body>
</html>
