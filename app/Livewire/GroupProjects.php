<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Groups;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;

class GroupProjects extends Component
{
    public $group = null;
    public $groupId = null;

    protected $listeners = ['groupSelected' => 'loadGroup'];

    public function mount($groupId = null)
    {
        if ($groupId) {
            $this->loadGroup($groupId);
        }
    }

    public function loadGroup($groupId)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur a accès à ce groupe
        if (!OrganizationService::userHasAccessToGroup($user, $groupId)) {
            $this->dispatch('showNotification', [
                'message' => 'Vous n\'avez pas accès à ce groupe.',
                'type' => 'error'
            ]);
            return;
        }

        $this->groupId = $groupId;
        $this->group = Groups::with([
            'projects' => function ($query) {
                $query->with(['tags', 'users', 'projectLinks', 'media']);
            },
            'promotion',
            'promotion.entity'
        ])->findOrFail($groupId);
    }

    public function render()
    {
        return view('livewire.group-projects');
    }
}
