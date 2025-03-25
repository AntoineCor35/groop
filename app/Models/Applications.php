<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applications extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'project_id',
        'user_id',
        'commentaire',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'project_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Projects::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
