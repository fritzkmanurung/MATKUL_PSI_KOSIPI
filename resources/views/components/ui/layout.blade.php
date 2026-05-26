<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <title>{{ $title ?? config('app.name', 'Kosipi') }}</title>

 <!-- Fonts -->
 <link rel="preconnect" href="https://fonts.bunny.net">
 <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

 <!-- Styles / Scripts -->
 @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
 @vite(['resources/css/app.css', 'resources/js/app.js'])
 @else
 <style>
 /* Fallback styles if needed */
 </style>
 @endif

 {{ $head ?? '' }}
</head>
<body {{ $attributes->merge(['class' => 'antialiased bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col']) }}>
 
 {{ $slot }}

 {{ $scripts ?? '' }}
</body>
</html>
