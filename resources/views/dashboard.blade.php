<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
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
                    <livewire:organization-sidebar wire:key="sidebar" />
                </div>

                <!-- Contenu principal - Composant Livewire -->
                <div class="w-full md:w-3/4">
                    <livewire:group-projects wire:key="projects" />
                </div>
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
