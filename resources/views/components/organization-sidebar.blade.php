@props(['entities' => []])

<div x-data="{
    entities: @js($entities),
    selectedEntityId: {{ count($entities) > 0 ? $entities[0]['id'] : 'null' }},
    expandedPromotions: {{ json_encode(collect($entities)->flatMap(fn($entity) => collect($entity['promotions'] ?? [])->pluck('id'))->all()) }},
    currentGroupId: null,
    loading: false,

    init() {},

    togglePromotion(id) {
        const index = this.expandedPromotions.indexOf(id);
        if (index === -1) {
            this.expandedPromotions.push(id);
        } else {
            this.expandedPromotions.splice(index, 1);
        }
    },

    selectGroup(groupId) {
        this.currentGroupId = groupId;
        this.loading = true;

        window.dispatchEvent(new CustomEvent('group-selected', {
            detail: parseInt(groupId)
        }));

        setTimeout(() => {
            this.loading = false;
        }, 300);
    }
}" class="relative h-full overflow-y-auto border border-gray-200 rounded-lg">
    <div x-show="loading" class="absolute inset-0 bg-white bg-opacity-50 flex items-center justify-center z-50">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
    </div>

    <!-- Entity Selection Header -->
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-sm font-medium text-gray-500">Organisation</h3>
            <button class="p-1 rounded-full hover:bg-gray-200 transition-colors duration-200"
                title="Créer une organisation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <div class="relative">
            <select x-model="selectedEntityId"
                class="w-full bg-white border border-gray-300 rounded-md py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <template x-for="entity in entities" :key="entity.id">
                    <option :value="entity.id" x-text="entity.name"></option>
                </template>
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
    </div>

    <!-- Promotions List -->
    <div class="p-4">
        <template x-for="entity in entities" :key="entity.id">
            <div x-show="selectedEntityId == entity.id">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium text-gray-700">Promotions</h4>
                    <button class="p-1 rounded-full hover:bg-gray-200 transition-colors duration-200"
                        title="Créer une promotion">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <ul class="space-y-2">
                    <template x-for="promotion in entity.promotions" :key="promotion.id">
                        <li class="bg-white rounded-md border border-gray-200">
                            <div class="flex items-center justify-between p-3 cursor-pointer hover:bg-gray-50 transition duration-150"
                                @click="togglePromotion(promotion.id)">
                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 7L12 3L20 7L12 11L4 7Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7V13" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 11V17" />
                                    </svg>
                                    <span class="font-medium text-sm" x-text="promotion.name"></span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-gray-400 transform transition-transform duration-200"
                                    :class="{ 'rotate-180': expandedPromotions.includes(promotion.id) }"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div x-show="expandedPromotions.includes(promotion.id)"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2">
                                <div class="flex justify-between items-center px-3 py-2">
                                    <h5 class="text-sm font-medium text-gray-600">Groupes</h5>
                                    <button class="p-1 rounded-full hover:bg-gray-200 transition-colors duration-200"
                                        title="Créer un groupe">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <ul class="p-2 space-y-1">
                                    <template x-for="group in promotion.groups" :key="group.id">
                                        <li>
                                            <button @click="selectGroup(group.id)"
                                                class="w-full text-left px-3 py-2 rounded-md text-sm hover:bg-gray-100 transition duration-150"
                                                :class="{ 'bg-blue-50 text-blue-700': currentGroupId == group.id }">
                                                <div class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        :class="currentGroupId == group.id ? 'text-blue-500' : 'text-gray-400'"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span x-text="group.name"></span>
                                                </div>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </template>
    </div>
</div>
