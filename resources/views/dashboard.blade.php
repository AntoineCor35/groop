<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Panneau latéral de l'organisation -->
        <div class="w-full md:w-1/4">
            <x-organization-sidebar :entities="$entities" :is-admin="$isAdmin" />
        </div>

        <!-- Contenu principal - Composant Livewire -->
        <div class="w-full md:w-3/4">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <livewire:group-projects wire:key="projects" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                // Écouter les changements de groupe
                window.addEventListener('group-selected', (e) => {
                    // On peut maintenant dispatcher l'événement vers le composant Livewire des projets
                    Livewire.dispatch('groupSelected', {
                        groupId: e.detail.groupId
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
