<?php

namespace Database\Seeders;

use Miracuthbert\LaravelRoles\Models\Permission;
use Miracuthbert\LaravelRoles\Models\Role;
use RolesAndPermissionsTableSeeder;

class RolesAndPermissionsTablesSeeder extends RolesAndPermissionsTableSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        parent::run();

        // more permissions
        $permissions = [
            'browse pages',
            'create page',
            'update page',
            'delete page',
            'manage settings',
            'browse tickets',
            'assign ticket agent',
            'manage ticket labels',
            'manage ticket categories',
            'update and resolve tickets',
            'browse apps',
            'create and edit apps',
            'delete and restore apps',
            'change app features',
        ];

        // get existing permissions
        $filteredPermissions = $this->existingPermissions($permissions);

        // filter out new permissions
        $newPermissions = $this->newPermissions($permissions, $filteredPermissions);

        // create new permissions
        $this->createPermissions($newPermissions);

        // more roles
        $roles = [
            'admin-root' => [
                'name' => 'Root',
                'type' => Role::ADMIN,
                'parent' => 'admin',
                'permissions' => array_merge($permissions, [
                    'manage settings',
                ]),
            ],
            'company' => [
                'name' => 'Company',
                'type' => 'company',
                'permissions' => [],
            ],
            'company-admin' => [
                'name' => 'Admin',
                'type' => 'company',
                'parent' => 'company',
                'permissions' => [
                    'view company dashboard',
                    'update company',
                    'delete company',
                    'add company user',
                    'delete company user',
                    'assign company roles',
                    'manage company subscriptions',
                    'browse projects',
                    'create project',
                    'view project',
                    'update project',
                    'update project status',
                    'handle project authorization',
                    'send customer invitation',
                    'delete project',
                    'setup moisture map',
                    'setup moisture map sensors',
                    'adjust moisture map readings',
                    'delete moisture map',
                    'setup psychrometric report sensors',
                    'adjust psychrometric report readings',
                    'post project log',
                    'update project log',
                    'delete project log',
                    'export project report',
                ],
            ],
            'company-member' => [
                'name' => 'Member',
                'type' => 'company',
                'parent' => 'company',
                'permissions' => [
                    'view company dashboard',
                    'browse projects',
                    'view project',
                    'update project',
                ],
            ],
        ];

        foreach ($roles as $slug => $data) {
            // get or create role
            $role = Role::firstOrCreate(['slug' => $slug], [
                'name' => $data['name'],
                'type' => $data['type'],
            ]
            );

            // setup parent
            if (isset($data['parent'])) {
                $parent = Role::where('slug', $data['parent'])->first();

                // append role to group
                $parent->appendNode($role);
            }

            $_permissions = $data['permissions'];

            // get existing permissions
            $existingPermissions = $this->existingPermissions($_permissions);

            // filter out new permissions
            $roleNewPermissions = $this->newPermissions($_permissions, $existingPermissions, $role->type);

            // create new permissions
            $this->createPermissions($roleNewPermissions);

            $permissionsId = Permission::whereIn('name',
                self::permissionsMap($_permissions, $role->type)->pluck('name')->toArray()
            )->pluck('id')->all();

            $role->addPermissions(
                $permissionsId
            );
        }
    }

    /**
     * Create new permissions.
     */
    protected function createPermissions($newPermissions)
    {
        foreach ($newPermissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'type' => $permission['type'] ?? Permission::ADMIN,
            ]);
        }
    }

    /**
     * Get existing permissions.
     *
     * @return mixed
     */
    protected function existingPermissions($permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    /**
     * Filter new permissions.
     *
     * @param  null  $type
     */
    protected function newPermissions($permissions, $filteredPermissions, $type = null): array
    {
        return self::permissionsMap($permissions, $type)->whereNotIn(
            'name', $filteredPermissions->pluck('name')->toArray()
        )->toArray();
    }

    /**
     * Get a collection of `permissions`.
     *
     * @param  null  $type
     * @return \Illuminate\Support\Collection
     */
    private static function permissionsMap(array $permissions, $type = null)
    {
        return collect($permissions)->map(function ($item) use ($type) {
            $newPermission = [
                'name' => $item,
            ];

            if (isset($type)) {
                $newPermission['type'] = $type;
            }

            return $newPermission;
        });
    }
}
