@extends('layouts.guest-layout')

@section('title', 'Groop - Tarifs')
@section('meta_description', 'Découvrez nos offres tarifaires adaptées à vos besoins pour la plateforme Groop.')

@section('content')
    <!-- Header -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-base font-semibold text-secondary tracking-wide uppercase">Tarifs</h1>
                <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                    Des offres adaptées à vos besoins
                </p>
                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                    Choisissez la formule qui correspond le mieux à votre établissement et à vos objectifs pédagogiques.
                </p>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div class="max-w-7xl mx-auto pb-24 px-4 sm:px-6 lg:px-8">
        <div class="mt-12 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
            <!-- Free Plan -->
            <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900">Étudiant</h3>

                    <div class="mt-4 flex items-baseline text-gray-900">
                        <span class="text-5xl font-extrabold tracking-tight">Gratuit</span>
                    </div>
                    <p class="mt-6 text-gray-500">
                        Parfait pour les étudiants qui souhaitent collaborer sur des projets.
                    </p>

                    <!-- Feature List -->
                    <ul role="list" class="mt-6 space-y-6">
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Accès complet à la plateforme</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Création de projets illimitée</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Collaboration en temps réel</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Outils de communication basiques</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Support communautaire</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('register') }}"
                    class="mt-8 block w-full bg-black py-3 px-6 border border-transparent rounded-md text-center font-medium text-white hover:bg-gray-800 transition-colors">
                    S'inscrire gratuitement
                </a>
            </div>

            <!-- Standard Plan -->
            <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4">
                    <span
                        class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-black text-white">
                        Populaire
                    </span>
                </div>

                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900">Établissement</h3>

                    <div class="mt-4 flex items-baseline text-gray-900">
                        <span class="text-5xl font-extrabold tracking-tight">299€</span>
                        <span class="ml-1 text-xl font-semibold">/mois</span>
                    </div>
                    <p class="mt-6 text-gray-500">
                        Idéal pour les écoles et universités de taille moyenne.
                    </p>

                    <!-- Feature List -->
                    <ul role="list" class="mt-6 space-y-6">
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">1 administration</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">5 promotions</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">10 professeurs</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">250 étudiants</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Tableau de bord administratif</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Outils d'évaluation avancés</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Support prioritaire</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('contact') }}"
                    class="mt-8 block w-full bg-black py-3 px-6 border border-transparent rounded-md text-center font-medium text-white hover:bg-gray-800 transition-colors">
                    Commencer maintenant
                </a>
            </div>

            <!-- Custom Plan -->
            <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900">Sur mesure</h3>

                    <div class="mt-4 flex items-baseline text-gray-900">
                        <span class="text-5xl font-extrabold tracking-tight">Contactez-nous</span>
                    </div>
                    <p class="mt-6 text-gray-500">
                        Solution personnalisée pour les grands établissements et réseaux d'écoles.
                    </p>

                    <!-- Feature List -->
                    <ul role="list" class="mt-6 space-y-6">
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Nombre illimité d'administrations</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Promotions illimitées</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Professeurs illimités</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Étudiants illimités</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Intégration avec vos systèmes existants</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Personnalisation complète</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-3 text-gray-500">Support dédié 24/7</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('contact') }}"
                    class="mt-8 block w-full bg-white py-3 px-6 border border-black rounded-md text-center font-medium text-black hover:bg-gray-50 transition-colors">
                    Demander un devis
                </a>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center">
                Questions fréquentes
            </h2>
            <div class="mt-12">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-12 lg:grid-cols-3">
                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Comment fonctionne l'offre gratuite pour les étudiants ?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            L'offre gratuite est accessible à tous les étudiants disposant d'une adresse email académique
                            valide. Elle offre un accès complet aux fonctionnalités de base de la plateforme.
                        </dd>
                    </div>

                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Puis-je changer de formule en cours d'année ?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Oui, vous pouvez passer à une formule supérieure à tout moment. Le changement prendra effet
                            immédiatement et la facturation sera ajustée au prorata.
                        </dd>
                    </div>

                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Comment est calculé le nombre d'étudiants ?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Le nombre d'étudiants correspond au nombre total de comptes étudiants actifs sur votre instance
                            Groop au cours du mois.
                        </dd>
                    </div>

                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Proposez-vous des remises pour les établissements publics ?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Oui, nous proposons des tarifs préférentiels pour les établissements publics et les associations
                            à but non lucratif. Contactez-nous pour en savoir plus.
                        </dd>
                    </div>

                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Quels moyens de paiement acceptez-vous ?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Nous acceptons les paiements par carte bancaire, virement bancaire et bon de commande
                            administratif pour les établissements publics.
                        </dd>
                    </div>

                    <div>
                        <dt class="text-lg leading-6 font-medium text-gray-900">
                            Proposez-vous une période d'essai ?
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            Oui, nous proposons une période d'essai de 30 jours pour la formule Établissement, sans
                            engagement et avec accès à toutes les fonctionnalités.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-black">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Prêt à transformer votre approche pédagogique ?</span>
                <span class="block text-gray-300">Commencez dès aujourd'hui avec Groop.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-black bg-white hover:bg-gray-100">
                        Essayer gratuitement
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
