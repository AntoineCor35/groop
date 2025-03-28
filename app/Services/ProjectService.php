<?php

namespace App\Services;

use App\Models\User;
use App\Models\Projects;
use App\Models\Applications;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    /**
     * Vérifie si un utilisateur est le créateur du projet.
     *
     * @param User $user
     * @param Projects $project
     * @return bool
     */
    public static function isProjectOwner(User $user, Projects $project): bool
    {
        return $project->owner_id === $user->id;
    }

    /**
     * Vérifie si un utilisateur est administrateur.
     *
     * @param User $user
     * @return bool
     */
    public static function isAdmin(User $user): bool
    {
        return $user->role === 'Admin';
    }

    /**
     * Vérifie si un utilisateur est modérateur dans le groupe du projet.
     *
     * @param User $user
     * @param Projects $project
     * @return bool
     */
    public static function isGroupModerator(User $user, Projects $project): bool
    {
        if ($user->role !== 'Modérateur') {
            return false;
        }

        // Le modérateur doit être lié au groupe, à la promotion ou à l'entité du projet
        $groupId = $project->group_id;
        $group = \App\Models\Groups::find($groupId);

        if (!$group) {
            return false;
        }

        return $user->groups()->where('groups.id', $groupId)->exists() ||
            $user->promotions()->where('promotions.id', $group->promotion_id)->exists() ||
            $user->entities()->where('entities.id', $group->promotion->entity_id)->exists();
    }

    /**
     * Vérifie si un utilisateur peut accepter une candidature à un projet.
     *
     * @param User $user
     * @param Projects $project
     * @return bool
     */
    public static function canManageApplications(User $user, Projects $project): bool
    {
        return self::isProjectOwner($user, $project) ||
            self::isAdmin($user) ||
            self::isGroupModerator($user, $project);
    }

    /**
     * Met à jour le statut d'une candidature et met à jour les membres du projet si nécessaire.
     *
     * @param Applications $application
     * @param string $newStatus
     * @return void
     */
    public static function updateApplicationStatus(Applications $application, string $newStatus): void
    {
        $application->status = $newStatus;
        $application->save();

        $project = $application->project;
        $user = $application->user;

        if ($newStatus === 'approved') {
            // Ajouter l'utilisateur au projet s'il n'y est pas déjà
            if (!$project->users->contains($user->id)) {
                $project->users()->attach($user->id);
            }
        } elseif ($newStatus === 'rejected') {
            // Si on rejette une candidature d'un utilisateur déjà membre, le retirer du projet
            if ($project->users->contains($user->id) && !self::isProjectOwner($user, $project)) {
                $project->users()->detach($user->id);
            }
        }
    }
}
