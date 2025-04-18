@props(['entities' => []])

<!-- Debug data -->
<script>
    console.log('Données initiales complètes:', @json($entities));
</script>

<div x-data="{
    entities: @js($entities),
    currentGroupId: null,
    currentGroup: null,
    loading: false,

    getTagColor(tagName) {
        const colors = [
            'bg-blue-100 text-blue-800',
            'bg-green-100 text-green-800',
            'bg-purple-100 text-purple-800',
            'bg-yellow-100 text-yellow-800',
            'bg-red-100 text-red-800',
            'bg-indigo-100 text-indigo-800',
            'bg-pink-100 text-pink-800',
        ];

        let hash = 0;
        tagName = tagName || '';
        for (let i = 0; i < tagName.length; i++) {
            hash = ((hash << 5) - hash) + tagName.charCodeAt(i);
            hash = hash & hash;
        }
        hash = Math.abs(hash);

        return colors[hash % colors.length];
    },

    findGroup() {
        const groupId = parseInt(this.currentGroupId);
        if (isNaN(groupId)) {
            console.warn('ID de groupe invalide:', this.currentGroupId);
            return null;
        }

        console.log('Recherche du groupe:', groupId);
        if (!Array.isArray(this.entities)) {
            console.warn('Les entités ne sont pas un tableau:', this.entities);
            return null;
        }

        for (const entity of this.entities) {
            if (!entity?.promotions) continue;
            for (const promotion of entity.promotions) {
                if (!promotion?.groups) continue;
                for (const group of promotion.groups) {
                    if (group?.id === groupId) {
                        console.log('Groupe trouvé:', group);
                        return {
                            ...group,
                            projects: Array.isArray(group.projects) ? group.projects : []
                        };
                    }
                }
            }
        }
        console.log('Groupe non trouvé');
        return null;
    },

    init() {
        this.$watch('currentGroupId', (value) => {
            console.log('currentGroupId changé:', value);
            this.currentGroup = value ? this.findGroup() : null;
            console.log('Nouveau groupe:', this.currentGroup);
        });

        window.addEventListener('group-selected', (event) => {
            console.log('Événement group-selected reçu:', event.detail);
            this.currentGroupId = parseInt(event.detail);
        });
    }
}" class="flex flex-col space-y-4 p-4">
    <template x-if="currentGroup">
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-semibold mb-2" x-text="currentGroup.name || 'Sans nom'"></h2>
                <p class="text-gray-600" x-text="currentGroup.description || 'Aucune description'"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <template x-for="project in currentGroup.projects" :key="project?.id">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <template x-if="project?.media?.length > 0 && project.media[0]?.preview_url">
                            <img :src="project.media[0].preview_url" class="w-full h-48 object-cover"
                                :alt="project.name || 'Image du projet'">
                        </template>

                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2" x-text="project?.name || 'Projet sans nom'"></h3>
                            <p class="text-gray-600 mb-4" x-text="project?.description || 'Aucune description'"></p>

                            <div class="flex flex-wrap gap-2">
                                <template x-for="tag in (project?.tags || [])" :key="tag?.id">
                                    <span class="px-2 py-1 rounded text-sm font-medium" :class="getTagColor(tag?.name)"
                                        x-text="tag?.name || 'Tag sans nom'">
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="!currentGroup.projects?.length">
                    <div class="col-span-full text-center py-8 text-gray-500">
                        Aucun projet dans ce groupe
                    </div>
                </template>
            </div>
        </div>
    </template>

    <template x-if="!currentGroup">
        <div class="text-center py-8 text-gray-500">
            Sélectionnez un groupe pour voir ses projets
        </div>
    </template>
</div>
