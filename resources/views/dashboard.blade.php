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

        <!-- Contenu principal - Composant Blade -->
        <div class="w-full md:w-3/4">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <x-group-projects :entities="$entities" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            console.log('Dashboard script loading...');

            // Écouter les changements de groupe
            window.addEventListener('group-selected', (e) => {
                console.log('Dashboard caught group-selected event:', e.detail);
            });
        </script>
    @endpush
</x-app-layout>
