<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::select('*')->join('users', 'users.id', 'admins.user_id')->where('users.username', 'admin_bd1')->first();

        // $role = Role::firstOrCreate([
        //     'name' => 'super admin',
        //     'guard_name' => 'super-admin',
        // ], [
        //     'id' => Uuid::uuid4()->toString(),
        // ]);

        $user->assignRole('admin');
    }
}
