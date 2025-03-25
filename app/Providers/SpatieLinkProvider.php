<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Filament\Support\Facades\FilamentAsset;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;

class SpatieLinkProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Link FileUpload component with Spatie Media Library
        FileUpload::configureUsing(function (FileUpload $component) {
            // Add hooks but defer the name check until the hooks are actually called
            $component->afterStateHydrated(function (FileUpload $component, Model $record, ?array $state) {
                // Check component name when the hook is actually called
                $statePath = $component->getStatePath();

                Log::info('afterStateHydrated called for: ' . $statePath, [
                    'record_id' => $record->id,
                    'record_class' => get_class($record),
                    'initial_state' => $state,
                ]);

                if (!str_starts_with($statePath, 'cover') && !str_starts_with($statePath, 'gallery')) {
                    Log::info('Ignoring non-media field: ' . $statePath);
                    return;
                }

                if (!$record instanceof HasMedia) {
                    Log::warning('Record is not an instance of HasMedia', ['class' => get_class($record)]);
                    return;
                }

                $collection = str_starts_with($statePath, 'cover') ? 'cover' : 'gallery';
                $media = $record->getMedia($collection);

                Log::info('Media for collection: ' . $collection, [
                    'count' => $media->count(),
                    'media_items' => $media->map(fn($item) => [
                        'id' => $item->id,
                        'uuid' => $item->uuid,
                        'file_name' => $item->file_name,
                        'url' => $item->getUrl(),
                    ])->toArray()
                ]);

                if ($collection === 'cover') {
                    // Utiliser le format de fichier que FileUpload attend
                    if ($media->isNotEmpty()) {
                        $mediaItem = $media->first();
                        $state = [
                            'id' => $mediaItem->uuid, // S'assurer d'utiliser l'UUID ici
                            'name' => $mediaItem->file_name,
                            'size' => $mediaItem->size,
                            'type' => $mediaItem->mime_type ?? 'image/jpeg',
                            'url' => $mediaItem->getFullUrl(),
                            // Ajouter ces champs pour assurer que FileUpload reconnaît le fichier comme existant
                            'status' => 'complete',
                            'path' => $collection . '/' . $mediaItem->file_name,
                        ];
                    } else {
                        $state = null;
                    }

                    Log::info('Setting cover state', ['state' => $state]);
                } else {
                    $state = $media->map(function ($item) {
                        return [
                            'id' => $item->uuid, // S'assurer d'utiliser l'UUID ici
                            'name' => $item->file_name,
                            'size' => $item->size,
                            'type' => $item->mime_type ?? 'image/jpeg',
                            'url' => $item->getFullUrl(),
                            // Ajouter ces champs pour assurer que FileUpload reconnaît le fichier comme existant
                            'status' => 'complete',
                            'path' => 'gallery/' . $item->file_name,
                        ];
                    })->toArray();

                    Log::info('Setting gallery state', ['count' => count($state)]);
                }

                $component->state($state);

                Log::info('State hydrated for: ' . $statePath, ['final_state' => $state]);
            });

            $component->afterStateUpdated(function (FileUpload $component, Model $record, $state) {
                // Check component name when the hook is actually called
                $statePath = $component->getStatePath();

                Log::info('afterStateUpdated called for: ' . $statePath, ['state' => $state]);

                if (!str_starts_with($statePath, 'cover') && !str_starts_with($statePath, 'gallery')) {
                    return;
                }

                if (!$record instanceof HasMedia) {
                    Log::warning('Record is not an instance of HasMedia', ['class' => get_class($record)]);
                    return;
                }

                $collection = str_starts_with($statePath, 'cover') ? 'cover' : 'gallery';

                Log::info('Processing media for collection: ' . $collection, [
                    'record_id' => $record->id,
                    'state' => $state,
                    'directory' => $component->getDirectory()
                ]);

                if ($collection === 'cover') {
                    if (empty($state)) {
                        Log::info('Clearing media collection: ' . $collection);
                        // Utiliser la méthode sécurisée pour la collection cover
                        if (method_exists($record, 'clearCoverMediaCollection')) {
                            $record->clearCoverMediaCollection();
                        } else {
                            $record->clearMediaCollection($collection);
                        }
                    } else if (is_array($state) && isset($state['name'])) {
                        try {
                            // Add to media library
                            Log::info('Adding cover media file', [
                                'file' => $state['name'],
                                'path' => $component->getDirectory() . '/' . $state['name']
                            ]);

                            // Utiliser la méthode sécurisée pour la collection cover
                            if (method_exists($record, 'clearCoverMediaCollection')) {
                                $record->clearCoverMediaCollection();
                            } else {
                                $record->clearMediaCollection($collection);
                            }

                            $record->addMediaFromDisk($component->getDirectory() . '/' . $state['name'], 'public')
                                ->toMediaCollection($collection);

                            Log::info('Cover media added successfully');
                        } catch (\Exception $e) {
                            // Log the error
                            Log::error('Failed to save media: ' . $e->getMessage(), [
                                'exception' => $e,
                                'file' => $state['name'] ?? 'unknown',
                                'path' => $component->getDirectory() . '/' . ($state['name'] ?? 'unknown')
                            ]);
                        }
                    }
                } else {
                    // For gallery (multiple files)
                    if (empty($state)) {
                        Log::info('Clearing gallery media collection');
                        $record->clearMediaCollection($collection);
                    } else if (is_array($state)) {
                        try {
                            // Clear existing media
                            $record->clearMediaCollection($collection);
                            Log::info('Adding gallery media files', ['count' => count($state)]);

                            // Add each file
                            foreach ($state as $index => $file) {
                                if (isset($file['name'])) {
                                    Log::info('Processing gallery file', [
                                        'index' => $index,
                                        'file' => $file['name'],
                                        'path' => $component->getDirectory() . '/' . $file['name']
                                    ]);

                                    $record->addMediaFromDisk($component->getDirectory() . '/' . $file['name'], 'public')
                                        ->toMediaCollection($collection);
                                }
                            }

                            Log::info('Gallery media files added successfully');
                        } catch (\Exception $e) {
                            // Log the error
                            Log::error('Failed to save media gallery: ' . $e->getMessage(), [
                                'exception' => $e,
                                'state' => $state
                            ]);
                        }
                    }
                }
            });

            // Dehydrating should be done based on name, but only at call time
            $component->dehydrated(function (FileUpload $component): bool {
                $statePath = $component->getStatePath();
                return !str_starts_with($statePath, 'cover') && !str_starts_with($statePath, 'gallery');
            });
        });
    }
}
