<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <script>/* Prevent flash */ (function(){if(localStorage.getItem('nv-theme')==='light')document.documentElement.classList.add('light');else document.documentElement.classList.add('dark');})();</script>
    <body class="font-sans text-white antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-navy-950">
            <div>
                <a href="/" class="text-gold font-bold text-3xl tracking-tight">
                    NovaVault
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-navy-900 border border-stroke shadow-lg overflow-hidden sm:rounded-nv">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
