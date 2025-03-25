@props(['entities'])

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full">
    <div class="p-4 text-gray-900 dark:text-gray-100">
        <h3 class="text-lg font-semibold mb-4">Organisation</h3>

        <ul class="space-y-2">
            @foreach ($entities as $entity)
                <li>
                    <!-- Entité avec dropdown -->
                    <div class="flex items-center justify-between py-2 px-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer entity-toggle"
                        data-entity-id="{{ $entity->id }}">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm6 6H7v2h6v-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $entity->name }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <a href="{{ route('filament.admin.resources.entities.edit', $entity->id) }}"
                                class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="entity-chevron h-5 w-5 text-gray-500 dark:text-gray-400 transform transition-transform"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Promotions de l'entité -->
                    <ul class="ml-6 space-y-1 mt-1 hidden entity-content" id="entity-{{ $entity->id }}">
                        @foreach ($entity->promotions as $promotion)
                            <li>
                                <!-- Promotion avec dropdown -->
                                <div class="flex items-center justify-between py-2 px-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer promotion-toggle"
                                    data-promotion-id="{{ $promotion->id }}">
                                    <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                        <span>{{ $promotion->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <a href="{{ route('filament.admin.resources.promotions.edit', $promotion->id) }}"
                                            class="text-blue-500 hover:text-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        @if ($promotion->groups->count() > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="promotion-chevron h-5 w-5 text-gray-500 dark:text-gray-400 transform transition-transform"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Groupes de la promotion -->
                                @if ($promotion->groups->count() > 0)
                                    <ul class="ml-6 space-y-1 mt-1 hidden promotion-content"
                                        id="promotion-{{ $promotion->id }}">
                                        @foreach ($promotion->groups as $group)
                                            <li>
                                                <a href="{{ route('filament.admin.resources.groups.edit', $group->id) }}"
                                                    class="flex items-center py-2 px-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <div class="flex items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path
                                                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                                                        </svg>
                                                        <span>{{ $group->name }}</span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle pour les entités
        document.querySelectorAll('.entity-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const entityId = this.getAttribute('data-entity-id');
                const content = document.getElementById('entity-' + entityId);
                const chevron = this.querySelector('.entity-chevron');

                content.classList.toggle('hidden');
                chevron.classList.toggle('rotate-180');
            });
        });

        // Toggle pour les promotions
        document.querySelectorAll('.promotion-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const promotionId = this.getAttribute('data-promotion-id');
                const content = document.getElementById('promotion-' + promotionId);
                const chevron = this.querySelector('.promotion-chevron');

                if (content) {
                    content.classList.toggle('hidden');
                    if (chevron) {
                        chevron.classList.toggle('rotate-180');
                    }
                }
            });
        });
    });
</script>
