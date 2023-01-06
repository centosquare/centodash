<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(
            ['name' => 'ordinary'],
        );

        $permission = Permission::whereIn('name', [
            'user.index',
            'role.index',
            'permission.index',
        ])->get();

        $role->givePermissionTo($permission);
    }
}
