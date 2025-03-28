<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groop - Connectez-vous autour de projets</title>
    <meta name="description"
        content="Groop simplifie la mise en relation entre étudiants autour de projets et valorise la diversité des talents.">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#4F46E5',
                        accent: '#818CF8',
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
    <!-- Navigation -->
    <nav class="bg-white shadow-sm" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="Groop Logo">
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                        <a href="#features"
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 h-16">
                            FONCTIONNALITÉS
                        </a>
                        <a href="#how-it-works"
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 h-16">
                            COMMENT ÇA MARCHE
                        </a>
                        <a href="#testimonials"
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 h-16">
                            TÉMOIGNAGES
                        </a>
                        <a href="{{ route('pricing') }}"
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 h-16">
                            TARIFS
                        </a>
                        <a href="{{ route('contact') }}"
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 h-16">
                            CONTACT
                        </a>
                    </div>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-secondary hover:bg-secondary/90 transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-secondary hover:bg-secondary/90 transition duration-150 ease-in-out">
                                Se connecter
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-secondary bg-white border-secondary hover:bg-gray-50 transition duration-150 ease-in-out">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
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
                <a href="#features"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    Fonctionnalités
                </a>
                <a href="#how-it-works"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    Comment ça marche
                </a>
                <a href="#testimonials"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    Témoignages
                </a>
                <a href="{{ route('pricing') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    Tarifs
                </a>
                <a href="{{ route('contact') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    Contact
                </a>
            </div>

            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4 space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="block px-4 py-2 text-base font-medium text-center text-white bg-secondary rounded-md hover:bg-secondary/90 transition duration-150 ease-in-out w-full">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="block px-4 py-2 text-base font-medium text-center text-white bg-secondary rounded-md hover:bg-secondary/90 transition duration-150 ease-in-out w-full">
                                Se connecter
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="block px-4 py-2 text-base font-medium text-center text-secondary bg-white border border-secondary rounded-md hover:bg-gray-50 transition duration-150 ease-in-out w-full">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                    fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>
                <div class="pt-10 mx-auto max-w-7xl px-4 sm:pt-12 sm:px-6 md:pt-16 lg:pt-20 lg:px-8 xl:pt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Trouvez votre équipe,</span>
                            <span class="block text-secondary">réalisez vos projets</span>
                        </h1>
                        <p
                            class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Notre plateforme claire et intuitive simplifie la mise en relation entre étudiants autour de
                            projets et valorise la diversité des talents.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-secondary hover:bg-secondary/90 md:py-4 md:text-lg md:px-10">
                                    Déposer un projet
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('register') }}"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-secondary bg-white border-secondary hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                    Trouver un projet
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1471&q=80"
                alt="Étudiants travaillant ensemble">
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-secondary font-semibold tracking-wide uppercase">Fonctionnalités</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Une plateforme conçue pour la collaboration
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Groop vous offre tous les outils nécessaires pour trouver les bonnes personnes et réaliser vos
                    projets.
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Pitcher des idées de projet
                            </p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Déposez vos concepts, décrivez vos besoins, et recrutez les bonnes personnes pour
                            concrétiser vos idées.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Trouver un projet</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Parcourez une carte interactive d'idées, filtrez par thématique ou compétences, et postulez
                            directement aux projets qui vous inspirent.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Collaborer efficacement</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Utilisez nos outils de communication et de gestion de projet pour travailler ensemble de
                            manière structurée.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Cadre structuré</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Bénéficiez d'un environnement organisé pour développer vos idées et mener à bien vos
                            projets.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div id="how-it-works" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-secondary font-semibold tracking-wide uppercase">Comment ça marche</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    En quelques étapes simples
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Que vous ayez une idée ou que vous cherchiez à rejoindre un projet, Groop vous simplifie la vie.
                </p>
            </div>

            <div class="mt-10">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-lg font-medium text-gray-900">
                            Pour ceux qui ont une idée
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white mb-4">
                            <span class="text-lg font-bold">1</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Créez votre compte</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Inscrivez-vous en quelques clics et complétez votre profil avec vos compétences et centres
                            d'intérêt.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white mb-4">
                            <span class="text-lg font-bold">2</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Déposez votre projet</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Décrivez votre idée, les compétences recherchées et les objectifs que vous souhaitez
                            atteindre.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white mb-4">
                            <span class="text-lg font-bold">3</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Constituez votre équipe</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Recevez des candidatures, échangez avec les candidats et sélectionnez les membres de votre
                            équipe.
                        </p>
                    </div>
                </div>

                <div class="relative mt-12">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-lg font-medium text-gray-900">
                            Pour ceux qui cherchent un projet
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white mb-4">
                            <span class="text-lg font-bold">1</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Créez votre profil</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Mettez en avant vos compétences, expériences et centres d'intérêt pour être visible auprès
                            des porteurs de projets.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white mb-4">
                            <span class="text-lg font-bold">2</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Explorez les projets</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Parcourez la carte interactive des projets et utilisez les filtres pour trouver ceux qui
                            correspondent à vos intérêts.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white mb-4">
                            <span class="text-lg font-bold">3</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Postulez et collaborez</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Envoyez votre candidature aux projets qui vous intéressent et commencez à collaborer une
                            fois accepté.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div id="testimonials" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-secondary font-semibold tracking-wide uppercase">Témoignages</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Ce que disent nos utilisateurs
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Découvrez comment Groop a aidé des étudiants à concrétiser leurs projets.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Sophie Martin</h3>
                            <p class="text-sm text-gray-500">Étudiante en informatique</p>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "Grâce à Groop, j'ai pu trouver des designers et des marketeurs pour mon application mobile.
                        Notre projet a même remporté un prix lors d'un hackathon universitaire !"
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Thomas Dubois</h3>
                            <p class="text-sm text-gray-500">Étudiant en design</p>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "En tant que designer, je cherchais à mettre mes compétences au service de projets concrets.
                        Groop m'a permis de rejoindre une startup étudiante passionnante et de développer mon
                        portfolio."
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Emma Petit</h3>
                            <p class="text-sm text-gray-500">Professeure d'entrepreneuriat</p>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "Groop a révolutionné la façon dont mes étudiants collaborent sur leurs projets. La plateforme
                        offre un cadre structuré qui facilite le suivi et l'évaluation des travaux de groupe."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-secondary">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Prêt à concrétiser vos idées ?</span>
                <span class="block text-indigo-100">Rejoignez Groop dès aujourd'hui.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-secondary bg-white hover:bg-indigo-50">
                        Créer un compte
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('pricing') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">À propos</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                Notre mission
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                L'équipe
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                Nos partenaires
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Ressources</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                Guide d'utilisation
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                FAQ
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                Blog
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Légal</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                Confidentialité
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                Conditions d'utilisation
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Contact</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                Support
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                contact@groop.fr
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </div>
                <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                    &copy; {{ date('Y') }} Groop. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js Initialization -->
    <script>
        document.addEventListener('alpine:init', () => {
            // Vous pouvez ajouter des composants Alpine.js personnalisés ici
        });
    </script>
</body>

</html>
