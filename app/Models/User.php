<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'password' => 'hashed',
    ];

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entities::class, 'entities_user', 'user_id', 'entity_id');
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotions::class, 'promotions_user', 'user_id', 'promotion_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Groups::class, 'groups_user', 'user_id', 'group_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Projects::class, 'projects_user', 'user_id', 'project_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Roles::class, 'roles_user', 'user_id', 'role_id');
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Media::class);
    }
}
