<?php

namespace App\Livewire;

use App\Models\Entities;
use Livewire\Component;
use Livewire\Attributes\On;

class OrganizationSidebar extends Component
{
    public $entities = [];
    public $isAdmin = false;
    public $currentGroupId = null;

    public function mount($entities = null, $isAdmin = false, $currentGroupId = null)
    {
        $this->isAdmin = $isAdmin;
        $this->currentGroupId = $currentGroupId;

        if ($entities) {
            $this->entities = $entities;
        } else {
            $this->loadEntities();
        }
    }

    public function loadEntities()
    {
        // Charger toutes les entités, même celles sans promotions
        $this->entities = Entities::with(['promotions' => function ($query) {
            $query->withCount('groups');
        }])->get()->map(function ($entity) {
            // S'assurer que promotions est toujours un tableau, même vide
            $entityArray = $entity->toArray();
            $entityArray['promotions'] = $entityArray['promotions'] ?? [];
            return $entityArray;
        })->toArray();
    }

    #[On('entity-created')]
    public function refreshEntities()
    {
        $this->loadEntities();
    }

    public function render()
    {
        return view('livewire.organization-sidebar');
    }
}
