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

        // Log pour déboguer
        Log::info('Données chargées:', [
            'nombre_entities' => $entities->count(),
            'structure' => $entities->map(function ($entity) {
                return [
                    'entity_id' => $entity->id,
                    'entity_name' => $entity->name,
                    'promotions' => $entity->promotions->map(function ($promotion) {
                        return [
                            'promotion_id' => $promotion->id,
                            'promotion_name' => $promotion->name,
                            'groups' => $promotion->groups->map(function ($group) {
                                return [
                                    'group_id' => $group->id,
                                    'group_name' => $group->name,
                                    'projects' => $group->projects->map(function ($project) {
                                        return [
                                            'project_id' => $project->id,
                                            'project_name' => $project->name,
                                            'has_media' => $project->media->isNotEmpty(),
                                            'tags_count' => $project->tags->count()
                                        ];
                                    })->toArray()
                                ];
                            })->toArray()
                        ];
                    })->toArray()
                ];
            })->toArray()
        ]);

        $isAdmin = $user && ($user->is_admin || $user->admin || $user->role === 'admin');

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
                                    'media' => array_merge(
                                        // Ajouter la cover si elle existe
                                        $project->cover ? [$project->cover] : [],
                                        // Ajouter la galerie
                                        $project->gallery ?? []
                                    ),
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

        // Log pour vérifier la structure finale
        Log::info('Structure finale des entités:', [
            'entities' => array_map(function ($entity) {
                return [
                    'id' => $entity['id'],
                    'name' => $entity['name'],
                    'promotions_count' => count($entity['promotions']),
                    'groups_count' => array_reduce($entity['promotions'], function ($carry, $promotion) {
                        return $carry + count($promotion['groups']);
                    }, 0),
                    'projects_count' => array_reduce($entity['promotions'], function ($carry, $promotion) {
                        return $carry + array_reduce($promotion['groups'], function ($carry, $group) {
                            return $carry + count($group['projects']);
                        }, 0);
                    }, 0)
                ];
            }, $entities)
        ]);

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
