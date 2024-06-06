<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/svgs/logo-mark.svg') }}" type="image/x-icon">
        <title>@yield('title') | {{ config('layout.name', 'E-Commerce') }}</title>

        @vite(['resources/css/frontend.css'])

        @livewireStyles
        
        @stack('css')

    </head>

    <body>
        
        <x-frontend.nav/>

        {{ $slot }}

        @livewireScripts

        <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(() => {
                $('#navbarToggler').on('click', function (e) {
                    let navigationMenu = $(this).attr('data-target')
                    $(navigationMenu).toggleClass('hidden')
                })
            })
        </script>

        @stack('js')
    </body>

</html>