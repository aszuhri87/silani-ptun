<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        // $user = Admin::select('*')->join('users', 'users.id', 'admins.user_id')->where('users.username', 'admin3')->first();

        // $role = Role::firstOrCreate([
        //     'name' => 'super admin',
        //     'guard_name' => 'super-admin',
        // ], [
        //     'id' => Uuid::uuid4()->toString(),
        // ]);

        $user = User::create([
            'name' => 'Supermin',
            'username' => 'super_admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('superTunx123'),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        Admin::create([
            'name' => $user->name,
            'user_id' => $user->id,
        ]);

        $user_role = User::where('email', $user->email)->first();

        $role = Role::where('name', 'super admin')->first();

        $user_role->assignRole($role);

        // $user->assignRole('super-admin');
    }
}
