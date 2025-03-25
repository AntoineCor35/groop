<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entities extends Model
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

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotions::class);
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
