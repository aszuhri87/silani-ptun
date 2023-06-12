<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Permission;

class PermissionAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $permissions = [
                'applicant_dashboard',
                'applicant_notifikasi',
                'applicant_inbox',
                'applicant_accepted_docs',
                'applicant_done',
                'applicant_profile',
                'applicant_create_docs',
            ];

            foreach ($permissions as $key => $permission) {
                if ($permission != null) {
                    Permission::firstOrCreate([
                        'name' => $permission,
                        'guard_name' => 'applicant',
                    ], [
                        'id' => Uuid::uuid4()->toString(),
                    ]);
                }
            }
        });
    }
}
