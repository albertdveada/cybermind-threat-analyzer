<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: window.innerWidth >= 768, showKey: false }" class="bg-gray-900 text-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} - SYSTEM</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>
    <body class="h-screen overflow-hidden">
        <div class="flex h-full">
            @include('layouts.navigation')
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 bg-gray-900 bg-opacity-75 md:hidden" @click="sidebarOpen = false"></div>
            <div class="flex-1 overflow-y-auto bg-gray-900 pt-16 px-4 md:pt-20 md:px-8">
                <button class="fixed top-4 left-4 z-50 bg-gray-700 text-white p-2 rounded-lg w-12 hover:bg-gray-600 transition" @click="sidebarOpen = !sidebarOpen">☰</button>
                {{-- PAGE CONTENT --}}
                @yield('content')
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
