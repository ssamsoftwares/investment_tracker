<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Naman Jain',
            'email' => 'naman17@outlook.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);


        $client = User::create([
            'name' => 'Client',
            'email' => 'client@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        // Admin
        $role = Role::where('name','admin')->first();
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);

        // Manager
        $manager_role = Role::where('name','manager')->first();
        // $manager_role->syncPermissions(['student-list','student-view','student-create','plan-list','plan-view','plan-create']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $manager->assignRole([$manager_role->id]);

        // Client
        $client_role = Role::where('name','client')->first();
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        // $client_role->syncPermissions(['student-list','student-view','student-create', 'student-edit','plan-list','plan-view','plan-create']);
        $client->assignRole([$client_role->id]);
    }
}
