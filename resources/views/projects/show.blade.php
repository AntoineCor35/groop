<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Fil d'Ariane -->
            <div class="mb-6 flex items-center text-sm text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('my-projects') }}" class="hover:text-gray-700">Mes Projets</a>
                <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-700 font-medium">{{ $project->name }}</span>
            </div>

            <!-- En-tête du projet -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="relative">
                    <!-- Image ou bannière du projet -->
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        @if ($project->media->isNotEmpty())
                            <img src="{{ asset('storage/' . $project->media->first()->path) }}"
                                alt="{{ $project->name }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-r from-indigo-500 to-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        @endif

                        <!-- Info du groupe et entité -->
                        @if ($project->group && $project->group->promotion && $project->group->promotion->entity)
                            <div
                                class="absolute top-4 left-4 px-3 py-1.5 bg-white/90 rounded-md shadow-sm text-sm font-medium text-gray-700">
                                {{ $project->group->promotion->entity->name }} - {{ $project->group->name }}
                            </div>
                        @endif

                        <!-- Statut du projet -->
                        @if ($project->status)
                            <div
                                class="absolute top-4 right-4 px-3 py-1.5 rounded-md shadow-sm text-sm font-medium
                                @if ($project->status === 'Terminé') bg-green-500 text-white
                                @elseif ($project->status === 'En cours') 
                                    bg-blue-500 text-white
                                @elseif ($project->status === 'En attente') 
                                    bg-yellow-500 text-white
                                @else
                                    bg-gray-500 text-white @endif">
                                {{ $project->status }}
                            </div>
                        @endif
                    </div>

                    <!-- Informations principales -->
                    <div class="p-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $project->name }}</h1>

                        <!-- Tags -->
                        @if ($project->tags->isNotEmpty())
                            <div class="mb-4 flex flex-wrap gap-2">
                                @foreach ($project->tags as $tag)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Détails du projet -->
                        <div class="prose max-w-none mt-4">
                            <p class="text-gray-700">{{ $project->description }}</p>
                        </div>

                        <!-- Métadonnées -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-200 pt-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Date de création</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($project->created_at)->format('d/m/Y') }}</p>
                            </div>

                            @if ($project->due_date)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Échéance</h3>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($project->due_date)->format('d/m/Y') }}</p>
                                </div>
                            @endif

                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Participants</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->regularMembers->count() }} membres
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu du projet -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Colonne principale -->
                <div class="lg:col-span-2">
                    <!-- Liens du projet -->
                    @if ($project->projectLinks && $project->projectLinks->isNotEmpty())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Liens utiles</h2>
                                <div class="space-y-3">
                                    @foreach ($project->projectLinks as $link)
                                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                            class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                            <div class="bg-indigo-100 text-indigo-500 p-2 rounded-md mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-900">{{ $link->title }}</h3>
                                                <p class="text-xs text-gray-500 truncate">{{ $link->url }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Conversation publique -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Discussions</h2>
                            @if ($publicConversation)
                                <livewire:comments-list :conversationId="$publicConversation->id" />

                                <!-- Formulaire Livewire pour ajouter un commentaire -->
                                <livewire:create-comment :conversationId="$publicConversation->id" />
                            @else
                                <div class="text-center py-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p class="text-gray-500">Aucune discussion pour le moment.</p>

                                    <!-- Formulaire Livewire pour créer une nouvelle conversation -->
                                    <livewire:create-comment :projectId="$project->id" type="public" />
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Conversation administrateurs (visible pour les admins et modérateurs) -->
                    @if ($isAdmin || $isModerator)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Discussion privée (Administration)
                                </h2>

                                @if ($adminConversation)
                                    <livewire:comments-list :conversationId="$adminConversation->id" />

                                    <!-- Formulaire Livewire pour ajouter un commentaire admin -->
                                    <livewire:create-comment :conversationId="$adminConversation->id" type="admin" />
                                @else
                                    <div class="text-center py-6 bg-red-50 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-12 w-12 mx-auto text-red-400 mb-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <p class="text-gray-700">Aucune discussion administrative pour le moment.</p>

                                        <!-- Formulaire Livewire pour créer une nouvelle conversation admin -->
                                        <livewire:create-comment :projectId="$project->id" type="admin" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Colonne latérale -->
                <div class="lg:col-span-1">
                    <!-- Membres du projet -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Membres du projet</h2>
                            <div class="space-y-3">
                                @foreach ($project->regularMembers as $user)
                                    <div class="flex items-center space-x-3">
                                        @if ($user->avatar)
                                            <img class="h-8 w-8 rounded-full"
                                                src="{{ asset('storage/' . $user->avatar->path) }}"
                                                alt="{{ $user->name }}">
                                        @else
                                            <div
                                                class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-medium">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Actions du projet -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                            <div class="space-y-3">
                                <a href="#"
                                    class="flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Éditer le projet
                                </a>
                                @if ($project->group)
                                    <a href="{{ route('groups.show', $project->group->id) }}"
                                        class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Voir le groupe
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
