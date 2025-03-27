<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OrganizationService;
use Illuminate\Support\Facades\Auth;

class OrganizationSidebar extends Component
{
    public $entities = [];
    public $currentGroupId = null;
    public $expandedEntities = [];
    public $expandedPromotions = [];

    protected $listeners = ['groupSelected' => 'setCurrentGroup'];

    public function mount($currentGroupId = null)
    {
        $this->currentGroupId = $currentGroupId;
        $this->loadEntities();

        // Si un groupe est sélectionné, assurons-nous que son entité et sa promotion sont expansées
        if ($currentGroupId) {
            $this->expandForGroup($currentGroupId);
        }
    }

    public function loadEntities()
    {
        $user = Auth::user();
        $this->entities = OrganizationService::getUserEntities($user);
    }

    public function expandForGroup($groupId)
    {
        foreach ($this->entities as $entity) {
            foreach ($entity->promotions as $promotion) {
                foreach ($promotion->groups as $group) {
                    if ($group->id == $groupId) {
                        $this->expandedEntities[] = $entity->id;
                        $this->expandedPromotions[] = $promotion->id;
                        return;
                    }
                }
            }
        }
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
        $this->currentGroupId = $groupId;
        $this->dispatch('groupSelected', $groupId);
    }

    public function setCurrentGroup($groupId)
    {
        $this->currentGroupId = $groupId;
    }

    public function render()
    {
        return view('livewire.organization-sidebar');
    }
}
