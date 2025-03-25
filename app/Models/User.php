<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'type',
        'avatar_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'avatar_id' => 'integer',
        'email_verified_at' => 'timestamp',
    ];

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entities::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotions::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Groups::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Projects::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Roles::class);
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Media::class);
    }
}
