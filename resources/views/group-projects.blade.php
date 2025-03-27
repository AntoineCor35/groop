<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $group->name }}
                </h2>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $group->promotion->entity->name }} / {{ $group->promotion->name }}
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="#"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                    MON GROUPE
                </a>
                <span class="text-gray-400">|</span>
                <a href="{{ route('profile.edit') }}"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                    PROFIL
                </a>
                <span class="text-gray-400">|</span>
                <a href="#"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                    CANDIDATURE
                </a>
                <span class="text-gray-400">|</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                        DÉCONNEXION
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Panneau latéral de l'organisation - Composant Livewire -->
                <div class="w-full md:w-1/4">
                    <livewire:organization-sidebar :current-group-id="$currentGroupId" />
                </div>

                <!-- Contenu principal - Composant Livewire -->
                <div class="w-full md:w-3/4">
                    <livewire:group-projects :group-id="$currentGroupId" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
