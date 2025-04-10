<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'create books',
            'edit books',
            'delete books',
            'borrow books',
            'return books',
            'manage users',
            'view users',
            'view borrowed books',
            'view returned books',


        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'Administrator']);
        $user = Role::create(['name' => 'user']);

        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo(['borrow books', 'return books']);

        $admin = User::first();
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
}
