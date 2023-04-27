<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Libraries\PageLib;
use App\Models\Applicant;
use App\Models\User;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ApplicantController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = DB::table('applicants')
        ->select('*')
        ->join('users', 'users.id', 'applicants.user_id')
        ->get();

        return view('admin.list-applicant.index', PageLib::config([]), ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('users')
        ->select([
            'users.id',
            'users.username',
            'users.email',
            'applicants.name',
            'users.title',
            'applicants.phone_number',
        ])
        ->join('applicants', 'applicants.user_id', 'users.id')
        ->where('users.category', 'karyawan')
        ->whereNull('users.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'title' => $request->title,
                    'category' => 'karyawan',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'gol' => $request->gol,
                ]);

                Applicant::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                ]);

                $user_role = User::where('email', $user->email)->first();

                $user_role->assignRole('applicant');
                // dd($user_role);

                return $user;
            });

            return response([
                'data' => $result,
                'message' => 'Data Tersimpan',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $result = DB::transaction(function () use ($request, $id) {
                $user = User::find($id);
                $user->update([
                    'name' => $request->name ? $request->name : $user->name,
                    'username' => $request->username ? $request->username : $user->username,
                    'email' => $request->email ? $request->email : $user->email,
                    'title' => $request->title ? $request->title : $user->title,
                    'password' => Hash::make($request->password) ? Hash::make($request->password) : $user->password,
                    'gol' => $request->gol,
                ]);

                $appl = Applicant::where('user_id', $id)->update([
                    'name' => $request->name ? $request->name : $appl->name,
                ]);

                $user_role = User::where('email', $user->email)->first();

                $user_role->assignRole('applicant');

                return $user;
            });

            return response([
                'data' => $result,
                'message' => 'Data Tersimpan',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $result = User::find($id);

            DB::transaction(function () use ($result) {
                $applicant = Applicant::where('user_id', $id);
                $applicant->delete();
                $result->delete();
            });

            if ($result->trashed()) {
                return response([
                    'message' => 'Successfully deleted!',
                ], 200);
            }
        } catch (Exception $e) {
            throw new Exception($e);

            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function download_format()
    {
        $file = public_path().'/format-list-pegawai.xlsx';

        return Response::download($file, 'format list pegawai.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport(), $request->file);

        return redirect()->back();
    }

    public function find_employee(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $letters = DB::table('users')
        ->select([
            'users.id',
            'users.name',
            ])
        ->where('users.name', 'ilike', '%'.$term.'%')
        ->where('users.category', 'karyawan')
        ->whereNull('users.deleted_at')
        ->get();

        $formatted_tags = [];

        foreach ($letters as $letter) {
            $formatted_tags[] = ['id' => $letter->id, 'text' => $letter->name];
        }

        return \Response::json($formatted_tags);
    }
}
