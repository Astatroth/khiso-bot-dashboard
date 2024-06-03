<?php

namespace App\Models\RBAC;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Builder
 */
class Permission extends Model
{
    use HasFactory;
    use AttributeTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title', 'slug', 'provided_by'
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($permission) {
            if (!method_exists(\App\Models\RBAC\Permission::class, 'bootSoftDeletes')) {
                $permission->roles()->sync([]);
            }

            return true;
        });
    }

    /*
     * Relations
     */

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions',
            'permission_id',
            'role_id'
        );
    }

    /*
     * Scopes
     */

    /**
     * Add a filter by 'provided_by' field.
     *
     * @param Builder $query
     * @param string  $key
     */
    public function scopeProvidedBy(Builder $query, string $key): void
    {
        $query->where('provided_by', $key);
    }
}
