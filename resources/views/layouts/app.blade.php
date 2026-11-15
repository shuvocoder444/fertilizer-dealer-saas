<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <x-banner />

        <!-- Navigation Menu Component -->
        @livewire('navigation-menu')

        <!-- Page Main Body (Adjusted for Fixed Sidebar & Header) -->
        <div class="lg:pl-64 pt-16 min-h-screen flex flex-col bg-gray-50">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white border-b border-gray-200 shadow-sm">
                    <div class="w-full max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1 w-full">
                {{ $slot }}
            </main>

            <!-- App Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-4 sm:px-6 lg:px-8 mt-auto">
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-2">
                    <div>
                        &copy; {{ date('Y') }} All rights reserved. Developed by <a href="http://webkoders.com/" target="_blank" rel="noopener noreferrer" class="text-emerald-600 font-bold hover:underline">webkoders</a>.
                    </div>
                    <div class="flex items-center gap-4">
                        <span>হটলাইন: <a href="tel:+8801790830250" class="font-semibold text-gray-700 hover:text-emerald-600">8801790830250</a></span>
                        <a href="http://webkoders.com/" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-600 font-medium">webkoders.com</a>
                    </div>
                </div>
            </footer>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>