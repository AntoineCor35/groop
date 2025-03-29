<?php

namespace App\Http\Controllers;

use App\Models\Applications;
use App\Models\Projects;
use App\Models\User;
use App\Models\Notifications;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationsController extends Controller
{
    /**
     * Affiche la liste des candidatures de l'utilisateur.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $applications = Applications::where('user_id', $user->id)
            ->with(['project', 'project.group', 'project.group.promotion', 'project.group.promotion.entity'])
            ->get();

        return view('applications.index', compact('applications'));
    }

    /**
     * Affiche le formulaire pour postuler à un projet.
     *
     * @param int $projectId
     * @return \Illuminate\View\View
     */
    public function create($projectId)
    {
        $project = Projects::with(['group', 'group.promotion', 'group.promotion.entity', 'tags', 'users'])
            ->findOrFail($projectId);

        // Vérifier si l'utilisateur a déjà une candidature en cours pour ce projet
        $user = Auth::user();
        $existingApplication = Applications::where('user_id', $user->id)
            ->where('project_id', $projectId)
            ->first();

        return view('applications.create', compact('project', 'existingApplication'));
    }

    /**
     * Enregistre une nouvelle candidature.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'commentaire' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $projectId = $request->input('project_id');

        // Vérifier si l'utilisateur a déjà une candidature en cours
        $existingApplication = Applications::where('user_id', $user->id)
            ->where('project_id', $projectId)
            ->first();

        if ($existingApplication) {
            return redirect()->route('projects.show', $projectId)
                ->with('error', 'Vous avez déjà une candidature en cours pour ce projet.');
        }

        // Créer la nouvelle candidature
        $application = new Applications([
            'user_id' => $user->id,
            'project_id' => $projectId,
            'status' => 'pending',
            'commentaire' => $request->input('commentaire'),
        ]);
        $application->save();

        // Créer une notification pour le propriétaire du projet
        $project = Projects::find($projectId);
        if ($project->owner_id) {
            Notifications::create([
                'user_id' => $project->owner_id,
                'message' => 'Nouvelle candidature pour votre projet "' . $project->name . '"',
                'type' => 'application',
            ]);
        }

        return redirect()->route('applications.index')
            ->with('success', 'Votre candidature a été envoyée avec succès.');
    }

    /**
     * Accepte une candidature.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $application = Applications::findOrFail($id);
        $user = Auth::user();
        $project = $application->project;

        // Vérifier si l'utilisateur a le droit de gérer les candidatures
        if (!ProjectService::canManageApplications($user, $project)) {
            return redirect()->back()->with('error', 'Vous n\'avez pas l\'autorisation de gérer les candidatures pour ce projet.');
        }

        // Mettre à jour le statut de la candidature
        ProjectService::updateApplicationStatus($application, 'approved');

        // Créer une notification pour le candidat
        Notifications::create([
            'user_id' => $application->user_id,
            'message' => 'Votre candidature au projet "' . $project->name . '" a été acceptée',
            'type' => 'application',
        ]);

        return redirect()->back()->with('success', 'La candidature a été acceptée avec succès.');
    }

    /**
     * Refuse une candidature.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $application = Applications::findOrFail($id);
        $user = Auth::user();
        $project = $application->project;

        // Vérifier si l'utilisateur a le droit de gérer les candidatures
        if (!ProjectService::canManageApplications($user, $project)) {
            return redirect()->back()->with('error', 'Vous n\'avez pas l\'autorisation de gérer les candidatures pour ce projet.');
        }

        // Mettre à jour le statut de la candidature
        ProjectService::updateApplicationStatus($application, 'rejected');

        // Créer une notification pour le candidat
        Notifications::create([
            'user_id' => $application->user_id,
            'message' => 'Votre candidature au projet "' . $project->name . '" a été refusée',
            'type' => 'application',
        ]);

        return redirect()->back()->with('success', 'La candidature a été refusée.');
    }
}
