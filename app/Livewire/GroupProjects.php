<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Groups;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class GroupProjects extends Component
{
    public $group = null;
    public $groupId = null;

    public function mount($groupId = null)
    {
        if ($groupId) {
            Log::info('GroupProjects: mount avec groupId = ' . $groupId);
            $this->loadGroup($groupId);
        } else {
            Log::info('GroupProjects: mount sans groupId');
        }
    }

    #[On('groupSelected')]
    public function loadGroup($groupId)
    {
        Log::info('GroupProjects: loadGroup appelé avec groupId = ' . $groupId);

        // Réinitialiser le groupe pour éviter d'afficher les anciens projets
        $this->group = null;
        $this->groupId = null;

        $user = Auth::user();

        // Vérifier si l'utilisateur a accès à ce groupe
        if (!OrganizationService::userHasAccessToGroup($user, $groupId)) {
            $this->dispatch('showNotification', [
                'message' => 'Vous n\'avez pas accès à ce groupe.',
                'type' => 'error'
            ]);
            Log::warning('GroupProjects: Accès refusé au groupe ' . $groupId . ' pour l\'utilisateur ' . $user->id);
            return;
        }

        $this->groupId = $groupId;

        try {
            $this->group = Groups::with([
                'projects' => function ($query) {
                    $query->with(['tags', 'users', 'projectLinks', 'media']);
                },
                'promotion',
                'promotion.entity'
            ])->findOrFail($groupId);

            Log::info('GroupProjects: groupe chargé avec succès, ' . count($this->group->projects) . ' projets trouvés');
        } catch (\Exception $e) {
            Log::error('GroupProjects: Erreur lors du chargement du groupe: ' . $e->getMessage());
            $this->dispatch('showNotification', [
                'message' => 'Erreur lors du chargement du groupe: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function render()
    {
        Log::info('GroupProjects: render appelé, groupId = ' . ($this->groupId ?? 'null'));
        return view('livewire.group-projects');
    }
}
