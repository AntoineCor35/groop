<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Entities extends Model implements HasMedia
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
        'image_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'image_id' => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(200)
                    ->height(200);

                $this->addMediaConversion('preview')
                    ->width(400)
                    ->height(400);
            });
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotions::class, 'entity_id');
    }

    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(
            Groups::class,
            Promotions::class,
            'entity_id',
            'promotion_id',
            'id',
            'id'
        );
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entities_user', 'entity_id', 'user_id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Media::class);
    }
}
