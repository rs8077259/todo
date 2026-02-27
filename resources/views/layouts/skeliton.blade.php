<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-dvh h-screen">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>
        <tallstackui:script/>
        @vite(entrypoints: ['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        {{ $head??""}}
    </head>
    <body class="w-full min-h-screen">
        <x-toast/>
        {{ $slot }}

        @livewireScripts
    </body>
</html>