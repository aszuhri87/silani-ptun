<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::transaction(function () {
            $user = \App\Models\User::updateOrCreate([
                'email' => 'admin2@example.com',
            ],
            [
                'username' => 'admin_bd1',
                'name' => 'Admin bd1',
                'password' => \Hash::make('Tunx123admin'),
            ]);

            $admin = \App\Models\Admin::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'name' => $user->name,
            ]);
        });
    }
}
