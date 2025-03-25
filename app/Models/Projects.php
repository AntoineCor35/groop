<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Projects extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'group_id',
        'icon',
        'custom_icon',
        'image_id',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'cover',
        'gallery',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'group_id' => 'integer',
        'image_id' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'cover',
        'gallery',
    ];

    /**
     * Register the media collections for this model.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(250)
                    ->height(250)
                    ->nonQueued();

                $this->addMediaConversion('preview')
                    ->width(800)
                    ->height(450)
                    ->nonQueued();
            });

        $this->addMediaCollection('gallery')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(250)
                    ->height(250)
                    ->nonQueued();

                $this->addMediaConversion('preview')
                    ->width(800)
                    ->height(450)
                    ->nonQueued();
            });
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Applications::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversations::class);
    }

    public function projectLinks(): HasMany
    {
        return $this->hasMany(ProjectLinks::class, 'project_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_user', 'project_id', 'user_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tags::class, 'projects_tags', 'project_id', 'tag_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Groups::class, 'group_id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(\Spatie\MediaLibrary\MediaCollections\Models\Media::class, 'image_id');
    }

    /**
     * Clear the cover media collection safely.
     * 
     * @return void
     */
    public function clearCoverMediaCollection()
    {
        // Récupérer l'image de couverture
        $coverMedia = $this->getMedia('cover')->first();

        // Si cette image est référencée par image_id, mettre image_id à NULL
        if ($coverMedia && $this->image_id === $coverMedia->id) {
            $this->image_id = null;
            $this->save();
        }

        // Puis supprimer la collection
        $this->clearMediaCollection('cover');
    }

    /**
     * Get the cover attribute.
     * 
     * @return mixed
     */
    public function getCoverAttribute()
    {
        $media = $this->getMedia('cover');
        return $media->isNotEmpty() ? [
            'id' => $media->first()->uuid,
            'name' => $media->first()->file_name,
            'size' => $media->first()->size,
            'type' => $media->first()->mime_type,
            'url' => $media->first()->getFullUrl(),
        ] : null;
    }

    /**
     * Get the gallery attribute.
     * 
     * @return array
     */
    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery')->map(function ($item) {
            return [
                'id' => $item->uuid,
                'name' => $item->file_name,
                'size' => $item->size,
                'type' => $item->mime_type,
                'url' => $item->getFullUrl(),
            ];
        })->toArray();
    }

    /**
     * Set the cover attribute.
     * 
     * @param mixed $value
     * @return void
     */
    public function setCoverAttribute($value)
    {
        // This is handled by the SpatieLinkProvider - don't save to database
    }

    /**
     * Set the gallery attribute.
     * 
     * @param mixed $value
     * @return void
     */
    public function setGalleryAttribute($value)
    {
        // This is handled by the SpatieLinkProvider - don't save to database
    }
}
