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

        .active-nav-link {
            border-bottom: 2px solid var(--color-primary);
            color: var(--color-primary);
            font-weight: 500;
        }

        .nav-link {
            position: relative;
            transition: all 0.2s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--color-primary);
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active::after {
            width: 100%;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-white">
    <div class="min-h-screen bg-white">
        <!-- Navigation principale - fixe pour toutes les pages -->
        <nav class="bg-white shadow-sm" x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}">
                                <x-application-logo class="block h-10 w-auto" />
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-black text-black font-medium active' : 'border-transparent text-gray-500 hover:text-gray-700' }} h-16">
                                DASHBOARD
                            </a>

                            <a href="#"
                                class="nav-link inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('groups.*') ? 'border-black text-black font-medium active' : 'border-transparent text-gray-500 hover:text-gray-700' }} h-16">
                                MES GROUPES
                            </a>

                            <a href="#"
                                class="nav-link inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('candidature.*') ? 'border-black text-black font-medium active' : 'border-transparent text-gray-500 hover:text-gray-700' }} h-16">
                                CANDIDATURE
                            </a>

                            @if (Auth::user() && Auth::user()->role === 'Admin')
                                <a href="{{ url('admin') }}"
                                    class="nav-link inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('admin*') ? 'border-black text-black font-medium active' : 'border-transparent text-gray-500 hover:text-gray-700' }} h-16">
                                    ADMIN
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Dropdown du profil -->
                    <div class="hidden sm:flex sm:items-center">
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open"
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                                style="display: none;">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Profile') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'border-l-4 border-black text-black bg-gray-50' : 'border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium transition duration-150 ease-in-out">
                        DASHBOARD
                    </a>

                    <a href="#"
                        class="{{ request()->routeIs('groups.*') ? 'border-l-4 border-black text-black bg-gray-50' : 'border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium transition duration-150 ease-in-out">
                        MES GROUPES
                    </a>

                    <a href="#"
                        class="{{ request()->routeIs('candidature.*') ? 'border-l-4 border-black text-black bg-gray-50' : 'border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium transition duration-150 ease-in-out">
                        CANDIDATURE
                    </a>

                    @if (Auth::user() && Auth::user()->role === 'Admin')
                        <a href="{{ url('admin') }}"
                            class="{{ request()->is('admin*') ? 'border-l-4 border-black text-black bg-gray-50' : 'border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium transition duration-150 ease-in-out">
                            ADMIN
                        </a>
                    @endif
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="mt-3 space-y-1 px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <a href="{{ route('profile.edit') }}"
                            class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                            {{ __('Profile') }}
                        </a>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- <!-- Page Heading - Titre de la page (si nécessaire) -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset --}}

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Scripts empilés -->
    @stack('scripts')
</body>

</html>
