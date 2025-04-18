@props(['entities' => [], 'isAdmin' => false])
@php
    $user = auth()->user();
    $isAdmin = $user->hasRole('Admin');
@endphp

<div class="border border-gray-200 rounded-lg overflow-hidden h-full bg-white shadow-sm" x-data="{
    selectedEntityId: {{ count($entities) > 0 ? $entities[0]->id : 'null' }},
    expandedPromotions: {{ json_encode(collect($entities)->flatMap(fn($entity) => $entity->promotions)->pluck('id')->all()) }},
    currentGroupId: null,
    togglePromotion(id) {
        const index = this.expandedPromotions.indexOf(id);
        if (index === -1) {
            this.expandedPromotions.push(id);
        } else {
            this.expandedPromotions.splice(index, 1);
        }
    },
    isPromotionExpanded(id) {
        return this.expandedPromotions.includes(id);
    }
}">

    <!-- Entity Selection Header -->
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Organisation</h3>
        <div class="relative">
            <select x-model="selectedEntityId"
                class="w-full bg-white border border-gray-300 rounded-md py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @foreach ($entities as $entity)
                    <option value="{{ $entity->id }}">{{ $entity->name }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        @if ($isAdmin)
            <a href="{{ route('filament.admin.resources.entities.create') }}"
                class="mt-3 flex items-center w-full py-2 px-3 text-sm text-gray-600 rounded border border-dashed border-gray-300 hover:bg-gray-50 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-600" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                <span>Ajouter une organisation</span>
            </a>
        @endif
    </div>

    <!-- Promotions and Groups Section -->
    <div class="p-4">
        <h3 class="text-sm font-medium text-gray-500 mb-3">Promotions & Groupes</h3>
        <template x-for="entity in {{ json_encode($entities) }}" :key="entity.id">
            <div x-show="selectedEntityId == entity.id">
                <ul class="space-y-2">
                    <template x-for="promotion in entity.promotions" :key="promotion.id">
                        <li class="bg-white rounded-md border border-gray-200">
                            <div class="flex items-center justify-between p-3 cursor-pointer hover:bg-gray-50 transition duration-150"
                                @click="togglePromotion(promotion.id)">
                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                    <span class="font-medium text-sm" x-text="promotion.name"></span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-gray-600 transition-transform"
                                    :class="{ 'transform rotate-180': isPromotionExpanded(promotion.id) }"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <div x-show="isPromotionExpanded(promotion.id)"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="border-t border-gray-100 pl-4 py-1">
                                <ul class="space-y-1">
                                    <template x-for="group in promotion.groups" :key="group.id">
                                        <li>
                                            <div class="flex items-center py-2 px-3 rounded-md text-sm cursor-pointer"
                                                :class="currentGroupId === group.id ?
                                                    'bg-blue-50 text-blue-700 border-l-2 border-blue-500' :
                                                    'hover:bg-gray-50'"
                                                @click="currentGroupId = group.id; $dispatch('group-selected', { groupId: group.id })">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2"
                                                    :class="currentGroupId === group.id ? 'text-blue-600' : 'text-gray-600'"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                                                </svg>
                                                <span x-text="group.name"></span>
                                            </div>
                                        </li>
                                    </template>

                                    @if ($isAdmin)
                                        <li>
                                            <a :href="`{{ route('filament.admin.resources.groups.create') }}?promotion_id=${promotion.id}`"
                                                class="flex items-center w-full py-1.5 px-3 mt-1 text-xs text-gray-600 rounded hover:bg-gray-50 transition duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-3 w-3 mr-1 text-gray-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>Ajouter un groupe</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    </template>

                    @if ($isAdmin)
                        <li>
                            <a :href="`{{ route('filament.admin.resources.promotions.create') }}?entity_id=${selectedEntityId}`"
                                class="flex items-center w-full py-2 px-3 text-sm text-gray-600 rounded border border-dashed border-gray-300 hover:bg-gray-50 transition duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Ajouter une promotion</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </template>
    </div>
</div>
