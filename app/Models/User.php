<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class User extends Authenticatable
{
    /**
     * @use
     * HasFactory<\Database\Factories\UserFactory>
     */

    use HasApiTokens, HasFactory, Notifiable;
    //use SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'premium_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'premium_until' => 'datetime',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'premium_until' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(
            Task::class,
            Note::class,
            'user_id',         // Foreign key on the users table...
            'note_id',       // Foreign key on the tasks table...
            'id',              // Local key on the users table...
            'id'         // Local key on the notes table...
        );
    }

    public function hasActivePremium(): bool
    {
        return $this->premium_until !== null && $this->premium_until->isFuture();
    }

    public function profilePhoto(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')
            ->where('collection', 'profile_photo');
    }
}
