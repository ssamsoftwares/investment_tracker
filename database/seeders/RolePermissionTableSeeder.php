<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "name" => "admin"
            ],
            [
                "name" => "manager"
            ],
            [
                "name" => "client"
            ],
        ];

        $permissions = [

        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
