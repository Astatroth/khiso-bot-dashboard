<?php

namespace App\Services;

use App\Models\RBAC\Role;
use App\Models\User;
use App\Services\RBAC\RoleService;
use App\Traits\Cacheable;
use Illuminate\Support\Collection;

class UserService
{
    use Cacheable;

    /**
     * @var string
     */
    protected string $cacheKey = 'rbac_roles_for_user_';

    /**
     * Attach a role to a user.
     *
     * @param User  $user
     * @param int|Role $role
     */
    public function attachRole(User $user, mixed $role): void
    {
        if ($role instanceof Role) {
            $role = $role->getKey();
        }

        $user->roles()->attach($role);

        $this->updateRolesCache($user);
    }

    /**
     * Returns true if a user has one, some or all specified permissions.
     *
     * @param array<string>     $permissionSlugs
     * @param User|null $user
     * @param bool      $requireAll
     * @return bool
     */
    public function can(array $permissionSlugs, ?User $user = null, bool $requireAll = false): bool
    {
        $user = $user ?? auth()->user();

        foreach ($permissionSlugs as $permission) {
            $can = $this->hasPermission($permission, $user);

            if ($can && !$requireAll) {
                return true;
            } elseif (!$can && $requireAll) {
                return false;
            }
        }

        return $requireAll;
    }

    /**
     * Create a new user or return an existing one.
     *
     * @param string      $name
     * @param string      $username
     * @param string      $password
     * @param string|null $email
     * @param string|null $phone
     * @return User
     */
    public function create(
        string $name,
        string $username,
        string $password,
        ?string $email = null,
        ?string $phone = null
    ): User {

        return User::where('username', $username)->firstOr(fn () => User::create([
            'name' => $name,
            'username' => $username,
            'password' => \Hash::make($password),
            'email' => $email,
            'phone' => $phone
        ]));
    }

    /**
     * Flush the roles cache for a user.
     *
     * @param User $user
     */
    protected function flushCache(User $user): void
    {
        if ($this->cacheIsTaggable()) {
            \Cache::tags('user_roles')->flush();
        } else {
            \Cache::forget($this->cacheKey.$user->getKey());
        }
    }

    /**
     * Return a user's permissions, grouped by 'provided_by' field, if required.
     *
     * @param User|null $user
     * @param bool      $group
     * @return array
     */
    public function getPermissions(?User $user = null, bool $group = false): array
    {
        $permissions = [];
        $roleService = new RoleService();
        $user = $user ?? auth()->user();

        foreach ($this->getRoles($user) as $role) {
            foreach ($roleService->getPermissions($role) as $permission) {
                $permissions[] = $permission;
            }
        }

        if (!$group || empty($permissions)) {
            return $permissions;
        }

        return array_reduce($permissions, function ($groups, $item) {
            if (is_null($item->provided_by)) {
                $groups[] = $item->slug;
            } else {
                $groups[$item->provided_by][] = $item->slug;
            }

            return $groups;
        });
    }

    /**
     * Return a user's roles.
     *
     * @param User $user
     * @return Collection
     */
    public function getRoles(User $user): Collection
    {
        if ($this->cacheIsTaggable()) {
            return \Cache::tags('user_roles')->remember(
                $this->cacheKey.$user->getKey(),
                config('cache.ttl'),
                fn () => $user->roles()->get()
            );
        }

        return \Cache::remember(
            $this->cacheKey.$user->getKey(),
            config('cache.ttl'),
            fn () => $user->roles()->get()
        );
    }

    /**
     * Returns true if a user has a specified permission.
     *
     * @param string    $permissionSlug
     * @param User|null $user
     * @return bool
     */
    public function hasPermission(string $permissionSlug, ?User $user): bool
    {
        $user = $user ?? auth()->user();

        $roleService = new RoleService();
        foreach ($this->getRoles($user) as $role) {
            foreach ($roleService->getPermissions($role) as $permission) {
                if ($permissionSlug === $permission->slug) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Return true if a user has a specified role.
     *
     * @param string    $roleSlug
     * @param User|null $user
     * @return bool
     */
    public function hasRole(string $roleSlug, ?User $user = null): bool
    {
        $user = $user ?? auth()->user();

        foreach ($this->getRoles($user) as $role) {
            return $roleSlug === $role->slug;
        }

        return false;
    }

    /**
     * Returns true if a user has one, some or all of the specified roles.
     *
     * @param array<string>     $roleSlugs
     * @param User|null $user
     * @param bool      $requireAll
     * @return bool
     */
    public function hasRoles(array $roleSlugs, ?User $user = null, bool $requireAll = false): bool
    {
        $user = $user ?? auth()->user();

        foreach ($roleSlugs as $role) {
            $hasRole = $this->hasRole($role, $user);

            if ($hasRole && !$requireAll) {
                return true;
            } elseif (!$hasRole && $requireAll) {
                return false;
            }
        }

        return $requireAll;
    }

    /**
     * Update the roles cache for a user.
     *
     * @param User $user
     */
    protected function updateRolesCache(User $user): void
    {
        $this->flushCache($user);

        $this->getRoles($user);
    }
}
