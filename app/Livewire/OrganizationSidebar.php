<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OrganizationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class OrganizationSidebar extends Component
{
    public $entities = [];
    public $currentGroupId = null;
    public $expandedEntities = [];
    public $expandedPromotions = [];
    public $isAdmin = false;

    public function mount($currentGroupId = null)
    {
        $this->currentGroupId = $currentGroupId;
        Log::info('OrganizationSidebar: mount avec currentGroupId = ' . ($currentGroupId ?? 'null'));
        $this->loadEntities();

        // Vérifier si l'utilisateur est administrateur
        $user = Auth::user();
        // Vous pouvez adapter cette vérification selon votre système d'autorisation
        $this->isAdmin = $user && ($user->is_admin || $user->admin || $user->role === 'admin');

        // Si un groupe est sélectionné, assurons-nous que son entité et sa promotion sont expansées
        if ($currentGroupId) {
            $this->expandForGroup($currentGroupId);
        }
    }

    public function loadEntities()
    {
        $user = Auth::user();
        $this->entities = OrganizationService::getUserEntities($user);
        Log::info('OrganizationSidebar: ' . count($this->entities) . ' entités chargées');
    }

    public function expandForGroup($groupId)
    {
        foreach ($this->entities as $entity) {
            foreach ($entity->promotions as $promotion) {
                foreach ($promotion->groups as $group) {
                    if ($group->id == $groupId) {
                        $this->expandedEntities[] = $entity->id;
                        $this->expandedPromotions[] = $promotion->id;
                        Log::info('OrganizationSidebar: Expansion pour le groupe ' . $groupId . ', entity=' . $entity->id . ', promotion=' . $promotion->id);
                        return;
                    }
                }
            }
        }
        Log::warning('OrganizationSidebar: Aucune expansion trouvée pour le groupe ' . $groupId);
    }

    public function toggleEntity($entityId)
    {
        if (in_array($entityId, $this->expandedEntities)) {
            $this->expandedEntities = array_diff($this->expandedEntities, [$entityId]);
        } else {
            $this->expandedEntities[] = $entityId;
        }
    }

    public function togglePromotion($promotionId)
    {
        if (in_array($promotionId, $this->expandedPromotions)) {
            $this->expandedPromotions = array_diff($this->expandedPromotions, [$promotionId]);
        } else {
            $this->expandedPromotions[] = $promotionId;
        }
    }

    public function selectGroup($groupId)
    {
        Log::info('OrganizationSidebar: selectGroup appelé avec groupId = ' . $groupId);
        $this->currentGroupId = $groupId;

        // Dispatch de l'événement Livewire
        try {
            // Utiliser le format to() pour cibler spécifiquement le composant GroupProjects
            $this->dispatch('groupSelected', $groupId)->to('group-projects');
            Log::info('OrganizationSidebar: événement groupSelected dispatché avec groupId = ' . $groupId . ' vers group-projects');
        } catch (\Exception $e) {
            Log::error('OrganizationSidebar: Erreur lors du dispatch de l\'événement: ' . $e->getMessage());
        }
    }

    #[On('groupSelected')]
    public function setCurrentGroup($groupId)
    {
        Log::info('OrganizationSidebar: setCurrentGroup appelé avec groupId = ' . $groupId);
        $this->currentGroupId = $groupId;
    }

    public function render()
    {
        return view('livewire.organization-sidebar');
    }
}
