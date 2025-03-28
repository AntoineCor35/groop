<div class="border border-gray-200 rounded-lg overflow-hidden h-full bg-white">
    <div class="p-5 text-gray-900">
        <div class="mb-5">
            <h3 class="text-lg font-semibold mb-2 border-b pb-2">Organisation</h3>

            <!-- Bouton pour ajouter une organisation -->
            @if ($isAdmin)
                <a href="{{ route('filament.admin.resources.entities.create') }}"
                    class="flex items-center py-2 px-2 text-sm text-gray-600 rounded border border-dashed border-gray-300 hover:bg-gray-50 transition duration-150 mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-black" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Ajouter une organisation</span>
                </a>
            @endif
        </div>

        <ul class="space-y-2">
            @foreach ($entities as $entity)
                <li>
                    <!-- Entité avec dropdown -->
                    <div class="flex items-center justify-between py-2 px-2 rounded hover:bg-gray-50 cursor-pointer transition duration-150"
                        wire:click="toggleEntity({{ $entity->id }})">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm6 6H7v2h6v-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ $entity->name }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-600 transform transition-transform {{ in_array($entity->id, $expandedEntities) ? 'rotate-180' : '' }}"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Promotions de l'entité -->
                    <div class="ml-6 space-y-1 mt-1 {{ !in_array($entity->id, $expandedEntities) ? 'hidden' : '' }}">
                        <ul>
                            @foreach ($entity->promotions as $promotion)
                                <li>
                                    <!-- Promotion avec dropdown -->
                                    <div class="flex items-center justify-between py-2 px-2 rounded hover:bg-gray-50 cursor-pointer transition duration-150"
                                        wire:click="togglePromotion({{ $promotion->id }})">
                                        <div class="flex items-center space-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                            <span class="font-medium">{{ $promotion->name }}</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            @if ($promotion->groups->count() > 0)
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-600 transform transition-transform {{ in_array($promotion->id, $expandedPromotions) ? 'rotate-180' : '' }}"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Groupes de la promotion -->
                                    <div
                                        class="ml-6 space-y-1 mt-1 {{ !in_array($promotion->id, $expandedPromotions) ? 'hidden' : '' }}">
                                        <ul>
                                            @foreach ($promotion->groups as $group)
                                                <li>
                                                    <div
                                                        class="flex items-center justify-between py-2 px-2 rounded cursor-pointer transition duration-150
                                                        {{ $currentGroupId == $group->id ? 'bg-gray-100 border-l-2 border-black pl-1.5' : 'hover:bg-gray-50' }}">
                                                        <div class="flex items-center space-x-2"
                                                            wire:click="selectGroup({{ $group->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-gray-600" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                                                            </svg>
                                                            <span
                                                                class="{{ $currentGroupId == $group->id ? 'font-medium' : '' }}">{{ $group->name }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach

                                            <!-- Bouton pour ajouter un groupe -->
                                            @if ($isAdmin)
                                                <li>
                                                    <a href="{{ route('filament.admin.resources.groups.create', ['promotion_id' => $promotion->id]) }}"
                                                        class="flex items-center py-1.5 px-2 mt-1 text-sm text-gray-600 rounded hover:bg-gray-50 transition duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 mr-1 text-black" viewBox="0 0 20 20"
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
                            @endforeach

                            <!-- Bouton pour ajouter une promotion -->
                            @if ($isAdmin)
                                <li>
                                    <a href="{{ route('filament.admin.resources.promotions.create', ['entity_id' => $entity->id]) }}"
                                        class="flex items-center py-1.5 px-2 mt-1 text-sm text-gray-600 rounded hover:bg-gray-50 transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-black"
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
                </li>
            @endforeach
        </ul>
    </div>
</div>
