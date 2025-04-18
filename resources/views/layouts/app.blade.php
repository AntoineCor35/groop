<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Grōōp') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-icon {
            @apply h-12 w-12 flex items-center justify-center rounded-xl cursor-pointer;
            @apply hover:bg-gray-100 transition-all duration-200 ease-linear;
        }

        .sidebar-icon.active {
            @apply bg-gray-100;
        }

        .sidebar-tooltip {
            @apply absolute w-auto p-2 m-2 min-w-max left-14 rounded-md shadow-md text-white bg-gray-900 text-xs font-bold transition-all duration-100 scale-0 origin-left;
        }

        .sidebar-icon:hover .sidebar-tooltip {
            @apply scale-100;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen overflow-hidden" x-data="{ mobileMenuOpen: false, activeItem: '{{ request()->routeIs('dashboard') ? 'dashboard' : (request()->routeIs('my-projects') ? 'projects' : (request()->routeIs('candidature.*') ? 'candidature' : (request()->is('admin*') ? 'admin' : 'dashboard'))) }}' }">
        <!-- Mobile menu trigger -->
        <div class="fixed top-4 left-4 z-50 lg:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="flex items-center justify-center w-10 h-10 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="sr-only">Menu</span>
            </button>
        </div>

        <!-- Mobile sidebar -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-full"
            class="fixed inset-0 z-40 lg:hidden">
            <div class="relative flex flex-col w-64 h-full bg-white border-r">
                <div class="p-4 border-b">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200">
                            <span class="font-bold text-lg">G</span>
                        </div>
                        <span class="text-lg font-semibold">{{ config('app.name', 'Grōōp') }}</span>
                    </div>
                </div>
                <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 p-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('my-projects') }}"
                        class="flex items-center space-x-3 p-2 rounded-md {{ request()->routeIs('my-projects') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Mes Projets</span>
                    </a>

                    <a href="#"
                        class="flex items-center space-x-3 p-2 rounded-md {{ request()->routeIs('candidature.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span>Candidature</span>
                    </a>

                    @if (Auth::user() && Auth::user()->role === 'Admin')
                        <a href="{{ url('admin') }}"
                            class="flex items-center space-x-3 p-2 rounded-md {{ request()->is('admin*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Admin</span>
                        </a>
                    @endif
                </nav>

                <div class="p-4 border-t">
                    <div class="flex items-center space-x-3">
                        @if (Auth::user() && Auth::user()->avatar)
                            <img class="w-10 h-10 rounded-full"
                                src="{{ asset('storage/' . Auth::user()->avatar->path) }}"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="font-medium text-sm">{{ substr(Auth::user()->name ?? 'U', 0, 2) }}</span>
                            </div>
                        @endif
                        <div>
                            <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop sidebar -->
        <div class="hidden lg:flex flex-col w-16 bg-gray-100 border-r">
            <div class="flex flex-col items-center py-4 space-y-6">
                <a href="{{ route('dashboard') }}" class="mb-6">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200">
                        <span class="font-bold text-lg">G</span>
                    </div>
                </a>

                <a href="{{ route('dashboard') }}" @click="activeItem = 'dashboard'"
                    :class="{ 'bg-blue-600 text-white': activeItem === 'dashboard', 'text-gray-500 hover:bg-gray-200': activeItem !== 'dashboard' }"
                    class="flex items-center justify-center w-10 h-10 rounded-md" title="Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>

                <a href="{{ route('my-projects') }}" @click="activeItem = 'projects'"
                    :class="{ 'bg-blue-600 text-white': activeItem === 'projects', 'text-gray-500 hover:bg-gray-200': activeItem !== 'projects' }"
                    class="flex items-center justify-center w-10 h-10 rounded-md" title="Mes Projets">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </a>

                <a href="#" @click="activeItem = 'candidature'"
                    :class="{ 'bg-blue-600 text-white': activeItem === 'candidature', 'text-gray-500 hover:bg-gray-200': activeItem !== 'candidature' }"
                    class="flex items-center justify-center w-10 h-10 rounded-md" title="Candidature">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </a>

                @if (Auth::user() && Auth::user()->role === 'Admin')
                    <a href="{{ url('admin') }}" @click="activeItem = 'admin'"
                        :class="{ 'bg-blue-600 text-white': activeItem === 'admin', 'text-gray-500 hover:bg-gray-200': activeItem !== 'admin' }"
                        class="flex items-center justify-center w-10 h-10 rounded-md" title="Admin">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                @endif
            </div>

            <div class="mt-auto mb-4 flex flex-col items-center">
                @if (Auth::user() && Auth::user()->avatar)
                    <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . Auth::user()->avatar->path) }}"
                        alt="{{ Auth::user()->name }}">
                @else
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="font-medium text-sm">{{ substr(Auth::user()->name ?? 'U', 0, 2) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 overflow-auto bg-gray-50">
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>

</html>
