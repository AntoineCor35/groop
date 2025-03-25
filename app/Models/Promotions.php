<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotions extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'parent_promotion_id',
        'image_id',
        'entity_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_promotion_id' => 'integer',
        'image_id' => 'integer',
        'entity_id' => 'integer',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Groups::class);
    }

    public function parentPromotion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Promotions::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Media::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Entities::class);
    }
}
