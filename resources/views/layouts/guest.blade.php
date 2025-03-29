<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Groop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #000000;
            --color-secondary: #4F46E5;
            --color-accent: #818CF8;
        }

        .bg-secondary {
            background-color: var(--color-secondary);
        }

        .hover\:bg-secondary\/90:hover {
            background-color: rgba(79, 70, 229, 0.9);
        }

        .text-secondary {
            color: var(--color-secondary);
        }

        .border-secondary {
            border-color: var(--color-secondary);
        }

        .hover\:border-secondary:hover {
            border-color: var(--color-secondary);
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/">
                                <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="Groop Logo">
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 mx-4">Se connecter</a>
                        <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700">S'inscrire</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white shadow-sm mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Groop. Tous droits réservés.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
