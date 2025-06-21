<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tutors') }}</title>
        <script src="https://kit.fontawesome.com/601e75221f.js" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles & Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Kiri: Slot Form -->
            <div class="w-full md:w-1/2 flex items-center justify-center bg-white px-8">
                <div class="w-full max-w-md space-y-6">
                    {{ $slot }}
                </div>
            </div>

            <!-- Kanan: Gambar -->
            <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('images/background.jpg') }}')"
            >   
            </div>
        </div>
    </body>
</html>
