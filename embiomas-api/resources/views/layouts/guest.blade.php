<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UmBiomas') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center" style="background-image: url('{{ asset('images/bg_img.jpg') }}')">

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-green-50 border-2 border-green-900 shadow-xl overflow-hidden sm:rounded-lg">

                <div class="mb-6 text-center">
                    <a href="/">
                        <img src="{{ asset('images/logo_tr.png') }}" alt="UmBiomas Logo" class="h-16 mx-auto">
                    </a>

                    <h1 class="text-4xl font-extrabold text-gray-800 mt-2" style="font-family: 'Lato', sans-serif;">
                        UmBiomas
                    </h1>

                    <p class="text-lg text-gray-600" style="font-family: 'Lato', sans-serif;">
                        Explore, aprenda e colabore.
                    </p>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
