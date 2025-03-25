<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projects extends Model
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
        'group_id',
        'icon',
        'image_id',
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
        return $this->hasMany(ProjectLinks::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Users::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tags::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Groups::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Media::class);
    }
}
