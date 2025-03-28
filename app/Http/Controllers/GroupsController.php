<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groups;
use App\Models\Entities;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;

class GroupsController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur a accès à ce groupe
        if (!OrganizationService::userHasAccessToGroup($user, $id)) {
            abort(403, 'Vous n\'avez pas accès à ce groupe.');
        }

        // Nous avons simplement besoin de récupérer le groupe pour l'en-tête de la page
        // Les composants Livewire s'occuperont du reste
        $group = Groups::with(['promotion', 'promotion.entity'])->findOrFail($id);

        $currentGroupId = $id;

        return view('group-projects', compact('group', 'currentGroupId'));
    }
}
