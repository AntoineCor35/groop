<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Mes Projets</h1>
                <p class="mt-2 text-gray-600">Voici tous les projets auxquels vous participez</p>
            </div>

            @if ($allProjects->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-500 text-lg">Vous ne participez à aucun projet pour le moment.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($allProjects as $project)
                        <a href="{{ route('projects.show', $project->id) }}" class="block">
                            <div
                                class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="h-40 bg-gray-200 relative overflow-hidden">
                                    @if ($project->media->isNotEmpty())
                                        <img src="{{ asset('storage/' . $project->media->first()->path) }}"
                                            alt="{{ $project->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    @if ($project->group && $project->group->promotion && $project->group->promotion->entity)
                                        <div
                                            class="absolute top-2 left-2 px-2 py-1 bg-white/80 text-xs font-semibold rounded text-gray-700">
                                            {{ $project->group->promotion->entity->name }} - {{ $project->group->name }}
                                        </div>
                                    @endif

                                    @if ($project->status)
                                        <div
                                            class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-semibold
                                            @if ($project->status === 'Terminé') bg-green-100 text-green-800
                                            @elseif ($project->status === 'En cours') 
                                                bg-blue-100 text-blue-800
                                            @elseif ($project->status === 'En attente') 
                                                bg-yellow-100 text-yellow-800
                                            @else
                                                bg-gray-100 text-gray-800 @endif">
                                            {{ $project->status }}
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $project->name }}</h2>
                                    <p class="text-gray-600 text-sm line-clamp-3">{{ $project->description }}</p>

                                    @if ($project->tags->isNotEmpty())
                                        <div class="mt-3 flex flex-wrap gap-1">
                                            @foreach ($project->tags as $tag)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-4 flex items-center text-xs text-gray-500">
                                        <span>{{ $project->regularMembers->count() }} participants</span>
                                        @if ($project->due_date)
                                            <span class="ml-auto">Échéance:
                                                {{ \Carbon\Carbon::parse($project->due_date)->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
