<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use RealRashid\SweetAlert\Facades\Alert;

class UsersImport implements ToModel, WithStartRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $users = User::where('email', $row['3'])->first();
        $result = null;
        if ($row['3'] && !$users) {
            $result = DB::transaction(function () use ($row) {
                $user = User::create([
                    'name' => $row['1'],
                    'username' => $row['2'],
                    'email' => $row['3'],
                    'title' => $row['4'],
                    'nip' => $row['2'],
                    'gol' => $row['5'],
                    'password' => Hash::make($row['2']),
                    'category' => 'karyawan',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ]);

                $applicant = Applicant::create([
                    'user_id' => $user->id,
                    'name' => $row['1'],
                ]);

                $user_role = User::where('email', $user->email)->first();

                $user_role->assignRole('applicant');
            });
        } else {
            $users_up = User::where('email', $row['3']);
            $users_up->update([
                'name' => $row['1'],
                'username' => $row['2'],
                'email' => $row['3'],
                'title' => $row['4'],
                'nip' => $row['2'],
                'gol' => $row['5'],
            ]);
        }

        Alert::success('Berhasil', 'Data berhasil di import!');

        return $result;
    }

    public function startRow(): int
    {
        return 5;
    }
}
