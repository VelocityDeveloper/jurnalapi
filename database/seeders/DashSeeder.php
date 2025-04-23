<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //buat permission jika belum ada
        $permissions = [
            'page-task',
            'edit-task',
            'delete-task',
        ];

        foreach ($permissions as $permission) {
            //check permission
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
                $this->command->info('Permission created: ' . $permission);
            }
        }

        if (!Role::where('name', 'webdeveloper')->exists()) {
            $role = Role::create(['name' => 'webdeveloper']);

            $role->givePermissionTo([
                'page-dashboard',
                'create-post',
                'edit-post',
                'delete-post',
                'edit-user',
                'delete-user',
                'page-task',
                'edit-task',
                'delete-task',
            ]);

            $this->command->info('Role created: ' . 'webdeveloper');
        }

        //get role admin
        $role_admin = Role::where('name', 'admin')->first();
        $role_admin->givePermissionTo(Permission::all());

        //get role owner
        $role_owner = Role::where('name', 'owner')->first();
        $role_owner->givePermissionTo([
            'page-task',
            'edit-task',
            'delete-task',
        ]);

        //get role user
        $role_user = Role::where('name', 'user')->first();
        $role_user->givePermissionTo([
            'page-task',
            'edit-task',
            'delete-task',
        ]);

        //get all users
        $users = User::all();
        foreach ($users as $user) {
            $role_user = $user->role;
            if ($role_user == 'admin') {
                $user->assignRole('admin');
            } elseif ($role_user == 'webdeveloper') {
                $user->assignRole('webdeveloper');
            } elseif ($role_user == 'owner') {
                $user->assignRole('owner');
            } else {
                $user->assignRole('user');
            }
        }
    }
}
