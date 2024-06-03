<?php

namespace App\Services\RBAC;

use App\Models\RBAC\Permission;
use App\Models\RBAC\Role;
use App\Traits\Cacheable;
use Illuminate\Support\Collection;

class RoleService
{
    use Cacheable;

    /**
     * @var string
     */
    protected string $cacheKey = 'rbac_permissions_for_role_';

    /**
     * Attach a permission to a role.
     *
     * @param Role  $role
     * @param int|Permission $permission
     */
    public function attachPermission(Role $role, mixed $permission): void
    {
        if ($permission instanceof Permission) {
            $permission = $permission->getKey();
        }

        $role->permissions()->attach($permission);

        $this->updatePermissionsCache($role);
    }

    /**
     * Create a new role or return an existing one.
     *
     * @param string      $title
     * @param string|null $slug
     * @param string|null $ownerType
     * @param int|null    $ownerId
     * @return Role
     */
    public function create(
        string $title,
        ?string $slug = null,
        ?string $ownerType = null,
        ?int $ownerId = null
    ): Role {

        return Role::where([
            'slug' => $slug ?? slugify($title, '_'),
            'owner_type' => $ownerType,
            'owner_id' => $ownerId
        ])->firstOr(fn () => Role::create([
            'title' => $title,
            'slug' => $slug ?? slugify($title, '_'),
            'owner_type' => $ownerType,
            'owner_id' => $ownerId
        ]));
    }

    /**
     * Flush the permissions cache for a role.
     *
     * @param Role $role
     */
    protected function flushCache(Role $role): void
    {
        if ($this->cacheIsTaggable()) {
            \Cache::tags('role_permissions')->flush();
        } else {
            \Cache::forget($this->cacheKey.$role->getKey());
        }
    }

    /**
     * Return a role's permissions.
     *
     * @param Role $role
     * @return Collection
     */
    public function getPermissions(Role $role): Collection
    {
        if ($this->cacheIsTaggable()) {
            return \Cache::tags('role_permissions')->remember(
                $this->cacheKey.$role->getKey(),
                config('cache.ttl'),
                fn () => $role->permissions()->get()
            );
        }

        return \Cache::remember(
            $this->cacheKey.$role->getKey(),
            config('cache.ttl'),
            fn () => $role->permissions()->get()
        );
    }

    /**
     * Update the permissions cache for a role.
     *
     * @param Role $role
     */
    protected function updatePermissionsCache(Role $role): void
    {
        $this->flushCache($role);

        $this->getPermissions($role);
    }
}
