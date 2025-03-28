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
        $this->loadEntities();

        // Par défaut, toutes les entités et promotions sont déroulées
        $this->initExpandedState();

        // Vérifier si l'utilisateur est administrateur
        $user = Auth::user();
        $this->isAdmin = $user && ($user->is_admin || $user->admin || $user->role === 'admin');
    }

    protected function initExpandedState()
    {
        // Vider les tableaux
        $this->expandedEntities = [];
        $this->expandedPromotions = [];

        // Ajouter toutes les entités et promotions
        foreach ($this->entities as $entity) {
            $this->expandedEntities[] = $entity->id;

            foreach ($entity->promotions as $promotion) {
                $this->expandedPromotions[] = $promotion->id;
            }
        }
    }

    public function loadEntities()
    {
        $user = Auth::user();
        $this->entities = OrganizationService::getUserEntities($user);
    }

    public function toggleEntity($entityId)
    {
        if (in_array($entityId, $this->expandedEntities)) {
            // Retirer l'entité de la liste
            $index = array_search($entityId, $this->expandedEntities);
            if ($index !== false) {
                unset($this->expandedEntities[$index]);
                $this->expandedEntities = array_values($this->expandedEntities);
            }
        } else {
            // Ajouter l'entité à la liste
            $this->expandedEntities[] = $entityId;
        }
    }

    public function togglePromotion($promotionId)
    {
        if (in_array($promotionId, $this->expandedPromotions)) {
            // Retirer la promotion de la liste
            $index = array_search($promotionId, $this->expandedPromotions);
            if ($index !== false) {
                unset($this->expandedPromotions[$index]);
                $this->expandedPromotions = array_values($this->expandedPromotions);
            }
        } else {
            // Ajouter la promotion à la liste
            $this->expandedPromotions[] = $promotionId;
        }
    }

    public function expandForGroup($groupId)
    {
        foreach ($this->entities as $entity) {
            foreach ($entity->promotions as $promotion) {
                foreach ($promotion->groups as $group) {
                    if ($group->id == $groupId) {
                        // S'assurer que l'entité et la promotion sont expansées
                        if (!in_array($entity->id, $this->expandedEntities)) {
                            $this->expandedEntities[] = $entity->id;
                        }

                        if (!in_array($promotion->id, $this->expandedPromotions)) {
                            $this->expandedPromotions[] = $promotion->id;
                        }

                        return;
                    }
                }
            }
        }
    }

    public function selectGroup($groupId)
    {
        $this->currentGroupId = $groupId;

        // S'assurer que le groupe est visible
        $this->expandForGroup($groupId);

        // Dispatch de l'événement Livewire
        try {
            $this->dispatch('groupSelected', $groupId)->to('group-projects');
        } catch (\Exception $e) {
            Log::error('OrganizationSidebar: Erreur lors du dispatch: ' . $e->getMessage());
        }
    }

    #[On('groupSelected')]
    public function setCurrentGroup($groupId)
    {
        $this->currentGroupId = $groupId;
        $this->expandForGroup($groupId);
    }

    public function render()
    {
        return view('livewire.organization-sidebar');
    }
}
