<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Groups;
use App\Models\Applications;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;
use App\Services\ProjectService;

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
            ->with(['group', 'group.promotion', 'group.promotion.entity', 'media', 'tags', 'users', 'regularMembers'])
            ->get();

        // Récupérer les projets dont l'utilisateur est propriétaire
        $ownedProjects = Projects::where('owner_id', $user->id)
            ->with(['group', 'group.promotion', 'group.promotion.entity', 'media', 'tags', 'users', 'regularMembers'])
            ->get();

        // Fusionner les collections en évitant les doublons
        $allProjects = $projects->merge($ownedProjects)->unique('id');

        return view('my-projects', compact('allProjects'));
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
            'regularMembers',
            'owner',
            'applications' => function ($query) {
                $query->with('user');
            },
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

        // Vérifier si l'utilisateur a accès à ce projet (les admins ont toujours accès)
        if (
            $user->role !== 'Admin' &&
            !$project->users->contains($user) &&
            !OrganizationService::userHasAccessToGroup($user, $project->group_id) &&
            $project->owner_id !== $user->id
        ) {
            abort(403, 'Vous n\'avez pas accès à ce projet.');
        }

        // Filtrer les conversations par type
        $publicConversation = $project->conversations->where('type', 'public')->first();
        $adminConversation = $project->conversations->where('type', 'admin')->first();

        // Déterminer les différents niveaux d'accès
        $isAdmin = $user->role === 'Admin';
        $isModerator = $user->role === 'Modérateur' && ProjectService::isGroupModerator($user, $project);
        $isOwner = $project->owner_id === $user->id;
        $canManageApplications = ProjectService::canManageApplications($user, $project);

        // Récupérer les candidatures en attente si l'utilisateur peut les gérer
        $pendingApplications = null;
        if ($canManageApplications) {
            $pendingApplications = $project->applications()->where('status', 'pending')->with('user')->get();
        }

        // Vérifier si l'utilisateur a déjà candidaté à ce projet
        $userApplication = Applications::where('user_id', $user->id)
            ->where('project_id', $id)
            ->first();

        return view('projects.show', compact(
            'project',
            'publicConversation',
            'adminConversation',
            'isAdmin',
            'isModerator',
            'isOwner',
            'canManageApplications',
            'pendingApplications',
            'userApplication'
        ));
    }

    /**
     * Affiche le formulaire de création d'un projet.
     *
     * @param int $groupId
     * @return \Illuminate\View\View
     */
    public function create($groupId)
    {
        $user = Auth::user();
        $group = Groups::findOrFail($groupId);

        // Vérifier si l'utilisateur a accès à ce groupe
        if (!OrganizationService::userHasAccessToGroup($user, $groupId)) {
            abort(403, 'Vous n\'avez pas accès à ce groupe.');
        }

        return view('projects.create', compact('group'));
    }

    /**
     * Enregistre un nouveau projet.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'group_id' => 'required|exists:groups,id',
            'icon' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $groupId = $request->input('group_id');

        // Vérifier si l'utilisateur a accès à ce groupe
        if (!OrganizationService::userHasAccessToGroup($user, $groupId)) {
            abort(403, 'Vous n\'avez pas accès à ce groupe.');
        }

        // Créer le nouveau projet
        $project = new Projects([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'group_id' => $groupId,
            'icon' => $request->input('icon', 'heroicon-o-academic-cap'),
            'owner_id' => $user->id, // Définir le créateur comme propriétaire
        ]);
        $project->save();

        // Ajouter le créateur comme membre du projet
        $project->users()->attach($user->id);

        // Créer une candidature approuvée pour le créateur
        Applications::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'status' => 'approved',
            'commentaire' => 'Créateur du projet',
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Le projet a été créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un projet.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Auth::user();
        $project = Projects::with('group')->findOrFail($id);

        // Vérifier si l'utilisateur a le droit de modifier ce projet
        if ($project->owner_id !== $user->id && $user->role !== 'Admin') {
            abort(403, 'Vous n\'avez pas l\'autorisation de modifier ce projet.');
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Met à jour un projet existant.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $project = Projects::findOrFail($id);

        // Vérifier si l'utilisateur a le droit de modifier ce projet
        if ($project->owner_id !== $user->id && $user->role !== 'Admin') {
            abort(403, 'Vous n\'avez pas l\'autorisation de modifier ce projet.');
        }

        // Mettre à jour le projet
        $project->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'icon' => $request->input('icon', $project->icon),
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Le projet a été mis à jour avec succès.');
    }
}
