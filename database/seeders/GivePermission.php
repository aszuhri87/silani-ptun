<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class GivePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Role::where('name', 'super admin')->first();

        $permissions = [
            'admin_dashboard',
            'notification',
            'inbox',
            'accepted_docs',
            'done',
            'profile',
            'master_data',
            'create_docs',
            'manage_admin',
        ];

        foreach ($permissions as $key => $permission) {
            if ($permission != null) {
                $user->givePermissionTo($permission);
            }
        }
    }
}
