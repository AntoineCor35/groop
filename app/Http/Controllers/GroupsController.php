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

        $group = Groups::with([
            'projects' => function ($query) {
                $query->with(['tags', 'users', 'projectLinks', 'media']);
            },
            'promotion',
            'promotion.entity'
        ])
            ->findOrFail($id);

        // Récupérer les entités auxquelles l'utilisateur a accès pour la barre latérale
        $entities = OrganizationService::getUserEntities($user);
        $currentGroupId = $id;

        return view('group-projects', compact('group', 'entities', 'currentGroupId'));
    }
}
