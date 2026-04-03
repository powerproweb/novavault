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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-navy-950 text-white">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-navy-900 border-b border-stroke shadow-lg">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            @if(session('status'))
                <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                    <div class="bg-green-900/50 border border-green-700 text-green-300 p-4 rounded-nv-sm">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
