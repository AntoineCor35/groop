<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $group->name }}
            </h2>
            <span class="text-sm text-gray-600">
                {{ $group->promotion->entity->name }} / {{ $group->promotion->name }}
            </span>
        </div>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Panneau latéral de l'organisation - Composant Livewire -->
        <div class="w-full md:w-1/4">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <livewire:organization-sidebar wire:key="sidebar" :current-group-id="$currentGroupId" />
            </div>
        </div>

        <!-- Contenu principal - Composant Livewire -->
        <div class="w-full md:w-3/4">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <livewire:group-projects wire:key="projects" :group-id="$currentGroupId" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Initialisation des composants
                Livewire.hook('component.initialized', (component) => {
                    console.log('Composant initialisé:', component.name, component.id);
                });

                // Événements envoyés
                Livewire.hook('message.sent', (message, component) => {
                    console.log('Message envoyé par ' + component.name + ':', message);
                    // Afficher les événements spécifiquement
                    if (message.updateQueue.length > 0) {
                        message.updateQueue.forEach(update => {
                            if (update.type === 'dispatchBrowserEvent' && update.payload.event ===
                                'groupSelected') {
                                console.log('Événement groupSelected envoyé avec payload:', update
                                    .payload.params);
                            }
                        });
                    }
                });

                // Événements reçus
                Livewire.hook('message.received', (message, component) => {
                    console.log('Message reçu par ' + component.name + ':', message);
                });

                // Événements échoués
                Livewire.hook('message.failed', (message, component) => {
                    console.error('Message échoué pour ' + component.name + ':', message);
                });

                // Écouter spécifiquement l'événement groupSelected
                window.addEventListener('groupSelected', (e) => {
                    console.log('Événement groupSelected capturé au niveau global:', e.detail);
                });

                // Ajouter un écouteur pour les erreurs Livewire
                window.addEventListener('livewire:error', (event) => {
                    console.error('Erreur Livewire:', event.detail);
                });
            });
        </script>
    @endpush
</x-app-layout>
