<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Groups;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/groups/{group}', function (Groups $group) {
    Log::info('API - Chargement du groupe', [
        'group_id' => $group->id,
        'group_name' => $group->name
    ]);

    $group->load([
        'projects' => function ($query) {
            $query->with(['tags', 'media']);
        }
    ]);

    Log::info('API - Données chargées', [
        'projects_count' => $group->projects->count(),
        'projects' => $group->projects->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'media_count' => $project->media->count()
            ];
        })
    ]);

    return response()->json([
        'id' => $group->id,
        'name' => $group->name,
        'description' => $group->description,
        'projects' => $group->projects->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'tags' => $project->tags,
                'media' => $project->media->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->getUrl(),
                        'original_url' => $media->getUrl(),
                        'thumb_url' => $media->getUrl('thumb'),
                        'preview_url' => $media->getUrl('preview')
                    ];
                })
            ];
        })
    ]);
})->middleware('auth:sanctum');
