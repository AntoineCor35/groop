<div x-data="{ loading: false }" x-init="$watch('$wire.groupId', () => {
    loading = true;
    setTimeout(() => loading = false, 300);
})">
    <div x-show="!loading" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        @if ($group)
            <!-- Description du groupe -->
            <div class="bg-white overflow-hidden border border-gray-200 rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2 border-b pb-2">{{ $group->name }} - DESCRIPTION</h3>
                    <p>{{ $group->description ?? 'Aucune description disponible.' }}</p>
                </div>
            </div>

            <!-- Projets du groupe -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($group->projects as $project)
                    <div
                        class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-800 mb-2">{{ $project->name }}</h3>
                            <div class="aspect-video bg-gray-100 rounded mb-3 overflow-hidden">
                                @if ($project->cover)
                                    <img src="{{ asset($project->cover['url']) }}" alt="{{ $project->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="flex items-center justify-center h-32 bg-gray-100 text-gray-500 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                {{ Str::limit($project->description, 100) }}
                            </p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach ($project->tags as $tag)
                                    @php
                                        // Générer des couleurs de fond différentes selon le tag
                                        $colors = [
                                            'bg-blue-100 text-blue-800',
                                            'bg-green-100 text-green-800',
                                            'bg-purple-100 text-purple-800',
                                            'bg-yellow-100 text-yellow-800',
                                            'bg-red-100 text-red-800',
                                            'bg-indigo-100 text-indigo-800',
                                            'bg-pink-100 text-pink-800',
                                        ];
                                        $colorIndex = crc32($tag->name) % count($colors);
                                        $colorClass = $colors[$colorIndex];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('filament.admin.resources.projects.view', $project->id) }}"
                                    class="text-black hover:underline text-sm font-medium group transition duration-150 inline-flex items-center">
                                    Voir le projet
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-1 group-hover:translate-x-1 transition duration-150"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="border border-gray-200 rounded-lg overflow-hidden col-span-full">
                        <div class="p-6 text-center">
                            <p class="text-gray-500 mb-4">Aucun projet disponible pour ce groupe.</p>
                            <a href="{{ route('filament.admin.resources.projects.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Créer un projet
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        @else
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="p-6 text-center text-gray-500">
                    <p class="mb-4">Sélectionnez un groupe dans le panneau de navigation pour voir ses projets.</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        @endif
    </div>

    <div x-show="loading" class="flex justify-center items-center py-12">
        <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </div>

    @script
        // Notification system
        document.addEventListener('livewire:initialized', () => {
        @this.on('showNotification', (event) => {
        // Assuming you have some notification system like Toastr or similar
        // If not, you can add one or implement a simple one
        alert(event.message);
        });
        });
    @endscript
</div>
