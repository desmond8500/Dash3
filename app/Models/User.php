<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Zap\Models\Concerns\HasSchedules;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use searchTrait;
    use HasSchedules;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'avatar',
        'email',
        'password',
        'function',
    ];

    protected $rules = [
        'name'     => 'required|string|min:3',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:8',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setting(): HasOne
    {
        return $this->hasOne(setting::class);
    }

    /** Tâches affectées à ce technicien (application Dash3Tech). */
    public function techTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_technician')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    /** Informations temporaires partagées avec ce technicien. */
    public function techShares(): BelongsToMany
    {
        return $this->belongsToMany(TechShare::class, 'tech_share_user')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function techReports(): HasMany
    {
        return $this->hasMany(TechReport::class);
    }

    public function techAccessRequests(): HasMany
    {
        return $this->hasMany(TechAccessRequest::class);
    }

    public function isTechnician(): bool
    {
        return $this->hasRole(config('tech.role', 'technicien'));
    }
}
