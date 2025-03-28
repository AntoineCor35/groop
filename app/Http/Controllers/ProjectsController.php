<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Groups;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;

class ProjectsController extends Controller
{
    /**
     * Affiche la liste des projets de l'utilisateur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer tous les projets de l'utilisateur avec les relations nécessaires
        $projects = $user->projects()
            ->with(['group', 'group.promotion', 'group.promotion.entity', 'media', 'tags', 'users'])
            ->get();

        return view('my-projects', compact('projects'));
    }

    /**
     * Affiche les détails d'un projet spécifique.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $project = Projects::with([
            'group',
            'group.promotion',
            'group.promotion.entity',
            'media',
            'tags',
            'users',
            'conversations' => function ($query) {
                $query->select(['id', 'project_id', 'type']);
            },
            'conversations.comments' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'conversations.comments.user',
            'projectLinks'
        ])
            ->findOrFail($id);

        // Vérifier si l'utilisateur a accès à ce projet
        if (!$project->users->contains($user) && !OrganizationService::userHasAccessToGroup($user, $project->group_id)) {
            abort(403, 'Vous n\'avez pas accès à ce projet.');
        }

        // Filtrer les conversations par type
        $publicConversation = $project->conversations->where('type', 'public')->first();
        $adminConversation = $project->conversations->where('type', 'admin')->first();

        $isAdmin = $user->role === 'Admin' || $user->role === 'Moderator';

        return view('projects.show', compact('project', 'publicConversation', 'adminConversation', 'isAdmin'));
    }
}
