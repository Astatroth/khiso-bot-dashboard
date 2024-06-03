<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin Builder
 */
class User extends Authenticatable
{
    use AttributeTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'username', 'password', 'email', 'phone', 'email_verified_at', 'last_login_at', 'last_action_at'
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
        'last_action_at' => 'date',
        'last_login_at' => 'date',
        'password' => 'hashed',
    ];

    /*
     * Relations
     */

    /**
     * Returns a collection of user roles.
     *
     * @return BelongsToMany|Collection|\App\Models\RBAC\Role[]
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Models\RBAC\Role::class,
            'user_roles',
            'user_id',
            'role_id');
    }
}
