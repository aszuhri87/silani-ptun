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
use RealRashid\SweetAlert\Facades\Alert;

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
            'users.gol',
            'users.nip'
        ])
        ->join('applicants', 'applicants.user_id', 'users.id')
        ->where('users.category', 'karyawan')
        ->orderBy('users.created_at', 'desc')
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
                    'unit_id' => $request->unit_id,
                    'nip' => $request->nip
                ]);

                Applicant::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
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
                    'gol' => $request->gol ? $request->gol : $user->gol,
                    'nip' => $request->nip ? $request->nip : $user->nip
                ]);

                $appl = Applicant::where('user_id', $id);
                $appl->update([
                    'name' => $request->name ? $request->name : $appl->first()->name,
                    'unit_id' => $request->unit_id ? $request->unit_id : $appl->first()->unit_id
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

            DB::transaction(function () use ($result, $id) {
                $applicant = Applicant::where('user_id', $id);
                $applicant->delete();
                $result->delete();
            });

            return response([
                'message' => 'Successfully deleted!',
            ], 200);

        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function download_format()
    {
        $file = public_path().'/format-list-pegawai.xlsx';

        return Response::download($file, 'format list pegawai.xlsx');
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file;
            $ext = $file->extension();

            if($ext == 'xlsx' || $ext == 'xls' || $ext == 'csv'){
                $file_name = $file;
            } else {
                return response([
                    'message' => 'Format tidak sesuai'
                ], 500);
            }

            Excel::import(new UsersImport(), $file_name);

            return response([
                'message' => 'Data Tersimpan',
            ], 200);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Alert::danger('Gagal', 'Data gagal di import! pastikan sesuai contoh format');

            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
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
