<div class="mt-6 pt-4 border-t border-gray-200">
    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-2 bg-red-100 text-red-800 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="addComment" class="flex">
        @if ($conversationId)
            <!-- Si on a déjà une conversation, on n'a pas besoin de projectId ou type -->
        @else
            <input type="hidden" wire:model="projectId">
            <input type="hidden" wire:model="type">
        @endif

        <input type="text" wire:model="comment"
            placeholder="{{ $type === 'admin' ? 'Ajouter un commentaire administrateur...' : 'Ajouter un commentaire...' }}"
            class="flex-1 {{ $type === 'admin' ? 'border-red-300 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }} rounded-md shadow-sm">

        <button type="submit"
            class="ml-2 px-4 py-2 {{ $type === 'admin' ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500' }} text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2">
            Envoyer
        </button>
    </form>

    @error('comment')
        <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
