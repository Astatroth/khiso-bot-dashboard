<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\RBAC\PermissionService;
use App\Services\RBAC\RoleService;
use App\Services\UserService;
use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install or update the application';

    /**
     * Install constructor.
     *
     * @param RoleService       $roleService
     * @param PermissionService $permissionService
     * @param UserService       $userService
     */
    public function __construct(
        protected RoleService $roleService,
        protected PermissionService $permissionService,
        protected UserService $userService
    ) {

        parent::__construct();
    }

    /**
     * @return array
     */
    protected function createRolesAndPermissions(): array
    {
        $roles = [];

        foreach (config('rbac.roles') as $title => $permissions) {
            $roles[$title] = $this->roleService->create($title);

            foreach ($permissions as $group => $permission) {
                if (is_array($permission)) {
                    foreach ($permission as $actualPermission) {
                        $this->roleService->attachPermission(
                            $roles[$title],
                            $this->permissionService->create($actualPermission, group: $group)
                        );
                    }
                    continue;
                }

                $this->roleService->attachPermission(
                    $roles[$title],
                    $this->permissionService->create($permission)
                );
            }
        }

        return $roles;
    }

    /**
     * Create a user.
     *
     * @param string      $name
     * @param string      $username
     * @param string      $password
     * @param string|null $email
     * @param string|null $phone
     * @return User
     */
    protected function createUser(
        string $name,
        string $username,
        string $password,
        string $email = null,
        string $phone = null
    ): User {
        if (empty($password)) {
            throw new \InvalidArgumentException('Password cannot be empty.');
        }

        return $this->userService->create(
            $name,
            $username,
            $password,
            $email,
            $phone
        );
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        \DB::transaction(function () {
            $roles = $this->createRolesAndPermissions();

            foreach (config('install.users') as $name => $fields) {
                $user = $this->createUser(
                    $name,
                    $fields['username'],
                    $fields['password'],
                    $fields['email'],
                    $fields['phone']
                );

                $this->userService->attachRole($user->getModel(), $roles[$name]->getModel());
            }

        });
    }
}
