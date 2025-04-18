<?php

namespace App\Http\Controllers;

use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Groups;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les entités de l'utilisateur
        $entities = OrganizationService::getUserEntities($user);


        // Préchargement des relations
        $entities = $entities->map(function ($entity) {
            return $entity->load([
                'promotions' => function ($query) {
                    $query->with([
                        'groups' => function ($query) {
                            $query->with([
                                'projects' => function ($query) {
                                    $query->with(['tags', 'media']);
                                }
                            ]);
                        }
                    ]);
                }
            ]);
        });
        $isAdmin = $user && ($user->is_admin || $user->admin || $user->role === 'Admin' || $user->attributes->role === 'Admin');

        // Convertir les entités en tableau pour éviter les problèmes de sérialisation
        $entities = $entities->map(function ($entity) {
            return [
                'id' => $entity->id,
                'name' => $entity->name,
                'description' => $entity->description,
                'image_id' => $entity->image_id,
                'created_at' => $entity->created_at,
                'updated_at' => $entity->updated_at,
                'pivot' => $entity->pivot,
                'promotions' => $entity->promotions->map(function ($promotion) {
                    return [
                        'id' => $promotion->id,
                        'name' => $promotion->name,
                        'description' => $promotion->description,
                        'created_at' => $promotion->created_at,
                        'updated_at' => $promotion->updated_at,
                        'entity_id' => $promotion->entity_id,
                        'parent_promotion_id' => $promotion->parent_promotion_id,
                        'groups' => $promotion->groups->map(function ($group) {
                            $projects = $group->projects->map(function ($project) {
                                return [
                                    'id' => $project->id,
                                    'name' => $project->name,
                                    'description' => $project->description,
                                    'group_id' => $project->group_id,
                                    'created_at' => $project->created_at,
                                    'updated_at' => $project->updated_at,
                                    'tags' => $project->tags->map(function ($tag) {
                                        return [
                                            'id' => $tag->id,
                                            'name' => $tag->name
                                        ];
                                    })->toArray(),
                                    'media' => $project->getMedia('gallery')->map(function ($media) {
                                        try {
                                            return [
                                                'id' => $media->id,
                                                'url' => $media->getUrl(),
                                                'original_url' => $media->getUrl(),
                                                'thumb_url' => $media->getUrl('thumb'),
                                                'preview_url' => $media->getUrl('preview')
                                            ];
                                        } catch (\Exception $e) {
                                            return null;
                                        }
                                    })->filter()->values()->toArray()
                                ];
                            })->toArray();

                            return [
                                'id' => $group->id,
                                'name' => $group->name,
                                'description' => $group->description,
                                'promotion_id' => $group->promotion_id,
                                'created_at' => $group->created_at,
                                'updated_at' => $group->updated_at,
                                'image_id' => $group->image_id,
                                'projects' => $projects
                            ];
                        })->toArray()
                    ];
                })->toArray()
            ];
        })->toArray();

        return view('dashboard', [
            'entities' => $entities,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function showGroup($groupId)
    {
        $user = Auth::user();
        $entities = OrganizationService::getUserEntities($user);
        $isAdmin = $user && ($user->is_admin || $user->admin || $user->role === 'admin');

        // Charger le groupe avec ses projets et les médias associés
        $group = \App\Models\Groups::with([
            'projects' => function ($query) {
                $query->with(['tags', 'media']);
            }
        ])->findOrFail($groupId);

        return view('dashboard', [
            'entities' => $entities,
            'isAdmin' => $isAdmin,
            'selectedGroup' => $group
        ]);
    }
}
