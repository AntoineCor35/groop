<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Panneau latéral de l'organisation -->
                <div class="w-full md:w-1/4">
                    <x-sidebar-organization :entities="$entities" />
                </div>

                <!-- Contenu principal -->
                <div class="w-full md:w-3/4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-4">Bienvenue sur Groop !</h3>
                            <p class="mb-4">Utilisez le panneau latéral pour naviguer dans la structure
                                organisationnelle.</p>

                            <div class="mt-6">
                                <h4 class="text-md font-semibold mb-2">Aperçu des entités</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    @foreach ($entities as $entity)
                                        <li>
                                            <span class="font-medium">{{ $entity->name }}</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                                ({{ $entity->promotions->count() }} promotions,
                                                {{ $entity->promotions->sum(function ($promotion) {return $promotion->groups->count();}) }}
                                                groupes)
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
