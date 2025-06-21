<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tutors') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/601e75221f.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex min-h-screen">
        @include('layouts.navigation')
       
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            @include('layouts.nav-header')
           
            @include('layouts.mobile')
          

            <!-- Dashboard Content -->
            <main class="flex-1 p-4 bg-cover bg-center relative bg-gray-100"
               >
               <!-- style="background-image: url('{{ asset('images/background.jpg') }}');" -->
                <!-- Overlay -->
                <div class="absolute inset-0 backdrop-blur-sm"></div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>
    <!-- Page Heading -->
    <!-- @isset($header)
    <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
@endisset -->
    </div>
    <script>
        function openSidebar() {
            document.getElementById('mobileSidebar').classList.remove('-translate-x-full');
        }

        function closeSidebar() {
            document.getElementById('mobileSidebar').classList.add('-translate-x-full');
        }
    </script>
</body>

</html>
