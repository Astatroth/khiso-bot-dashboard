<?php

namespace App\Services\RBAC;

use App\Models\RBAC\Permission;

class PermissionService
{
    /**
     * Create a new permission or return an existing one.
     *
     * @param string      $title
     * @param string|null $slug
     * @param string|null $group
     * @return Permission
     */
    public function create(string $title, ?string $slug = null, string $group = null): Permission
    {
        return Permission::where('slug', $slug ?? slugify($title, '_'))
                                ->firstOr(fn () => Permission::create([
                                    'title' => $title,
                                    'slug' => $slug ?? slugify($title, '_'),
                                    'provided_by' => $group
                                ]));
    }
}
