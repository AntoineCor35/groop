<div>
    @if ($conversation && $conversation->comments->isNotEmpty())
        <div class="space-y-6 @if ($conversation->type === 'admin') bg-red-50 p-4 rounded-md @endif">
            @foreach ($conversation->comments as $comment)
                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        @if ($comment->user && $comment->user->avatar)
                            <img class="h-10 w-10 rounded-full"
                                src="{{ asset('storage/' . $comment->user->avatar->path) }}"
                                alt="{{ $comment->user->name }}">
                        @else
                            <div
                                class="h-10 w-10 rounded-full @if ($conversation->type === 'admin') bg-red-200 text-red-700 @else bg-gray-300 text-gray-700 @endif flex items-center justify-center">
                                {{ substr($comment->user->name ?? 'U', 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">
                                {{ $comment->user->name ?? 'Utilisateur' }}
                                @if ($conversation->type === 'admin')
                                    <span class="ml-2 text-xs text-red-600 font-normal">Admin</span>
                                @endif
                            </h3>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <div class="mt-1 text-sm text-gray-700">
                            <p>{{ $comment->comment }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-6 @if ($conversation && $conversation->type === 'admin') bg-red-50 @endif rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-12 w-12 mx-auto @if ($conversation && $conversation->type === 'admin') text-red-400 @else text-gray-400 @endif mb-4"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="text-gray-700">Aucune discussion
                {{ $conversation && $conversation->type === 'admin' ? 'administrative' : '' }} pour le moment.</p>
        </div>
    @endif
</div>
