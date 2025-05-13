<?php

namespace App\Services;

use App\Models\User;
use App\Models\Entities;
use Illuminate\Database\Eloquent\Collection;

class OrganizationService
{
    /**
     * Récupère toutes les entités auxquelles l'utilisateur a accès.
     *
     * @param User $user
     * @return Collection
     */
    public static function getUserEntities(User $user): Collection
    {
        // Si l'utilisateur est admin, retourner toutes les entités avec leurs relations
        if (
            $user->is_admin ?? false ||
            $user->admin ?? false ||
            ($user->role ?? '') === 'Admin' ||
            (isset($user->attributes) && ($user->attributes->role ?? '') === 'Admin')
        ) {
            return Entities::with(['promotions' => function ($query) {
                $query->with(['groups' => function ($query) {
                    $query->with(['projects' => function ($query) {
                        $query->with(['tags', 'media']);
                    }]);
                }]);
            }])->get();
        }

        // Pour les utilisateurs non-admin, garder la logique existante
        // Récupérer les entités auxquelles l'utilisateur a accès directement
        $userEntities = $user->entities()->with(['promotions' => function ($query) use ($user) {
            // Pour chaque entité, ne récupérer que les promotions auxquelles l'utilisateur a accès
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->orWhereDoesntHave('users') // Ou les promotions sans restriction d'utilisateurs
                ->with(['groups' => function ($query) use ($user) {
                    // Pour chaque promotion, ne récupérer que les groupes auxquels l'utilisateur a accès
                    $query->whereHas('users', function ($query) use ($user) {
                        $query->where('users.id', $user->id);
                    })->orWhereDoesntHave('users'); // Ou les groupes sans restriction d'utilisateurs
                }]);
        }])->get();

        // Récupérer aussi les promotions de l'utilisateur qui pourraient appartenir à des entités auxquelles il n'a pas accès directement
        $userPromotionsEntities = Entities::whereHas('promotions', function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        })->with(['promotions' => function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->with(['groups' => function ($query) use ($user) {
                $query->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })->orWhereDoesntHave('users');
            }]);
        }])->whereNotIn('id', $userEntities->pluck('id'))->get();

        // Récupérer aussi les groupes de l'utilisateur qui pourraient appartenir à des promotions auxquelles il n'a pas accès directement
        $userGroupsEntities = Entities::whereHas('promotions.groups', function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        })->with(['promotions' => function ($query) use ($user) {
            $query->whereHas('groups', function ($query) use ($user) {
                $query->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            })->with(['groups' => function ($query) use ($user) {
                $query->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            }]);
        }])->whereNotIn('id', $userEntities->pluck('id'))
            ->whereNotIn('id', $userPromotionsEntities->pluck('id'))
            ->get();

        // Fusionner les collections
        return $userEntities->concat($userPromotionsEntities)->concat($userGroupsEntities);
    }

    /**
     * Vérifie si un utilisateur a accès à un groupe spécifique.
     *
     * @param User $user
     * @param int $groupId
     * @return bool
     */
    public static function userHasAccessToGroup(User $user, int $groupId): bool
    {
        // Si l'utilisateur est admin, il a accès à tous les groupes
        if (
            $user->is_admin ?? false ||
            $user->admin ?? false ||
            ($user->role ?? '') === 'Admin' ||
            (isset($user->attributes) && ($user->attributes->role ?? '') === 'Admin')
        ) {
            return true;
        }

        return $user->groups()->where('groups.id', $groupId)->exists() ||
            \App\Models\Groups::where('id', $groupId)->whereDoesntHave('users')->exists();
    }
}
