<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UmBiomas') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="flex h-screen bg-gray-100">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="bg-gray-100 border-b border-gray-100 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 ">
                        <div class="flex items-center">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @include('layouts.navigation')
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto"
                style="
                background-image: url('{{ asset('images/bg_img.jpg') }}');
                background-size: cover;
                background-position: center center;
                background-attachment: fixed;">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')

</html>
</body>

</html>
