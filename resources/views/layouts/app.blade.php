<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MEX Kargo') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-poppins text-gray-900 antialiased bg-slate-50">

        <div class="flex min-h-screen">

            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col w-full min-h-screen pl-64 transition-all duration-300">

                @include('layouts.navigation')

                <!-- @if (isset($header))
                    <header class="bg-white shadow-sm border-b border-slate-200">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif -->

                <main class="flex-1 p-6 overflow-y-auto">
                    {{ $slot }}
                </main>

            </div>

        </div>
    </body>

</html>