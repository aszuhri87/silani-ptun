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

class GeneralApplicantController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = DB::table('applicants')
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
        ->leftJoin('users', 'users.id', 'applicants.user_id')
        ->where('users.category', 'umum')
        ->orWhereNull('users.category')
        ->orderBy('users.created_at', 'desc')
        ->whereNull('users.deleted_at')
        ->get();

        return view('admin.list-general-applicant.index', PageLib::config([]), ['data' => $data]);
    }

    public function dt()
    {
        $data = DB::table('applicants')
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
            ->leftJoin('users', 'users.id', 'applicants.user_id')
            ->where('users.category', 'umum')
            ->orWhereNull('users.category')
            ->orderBy('users.created_at', 'desc')
            ->whereNull('users.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function show($id)
    {
        $data = User::select([
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
            ->where('users.category', 'umum')
            ->orderBy('users.created_at', 'desc')
            ->whereNull('users.deleted_at')
            ->first();

            return response([
                'data' => $data,
                'message' => 'Successfully deleted!',
            ], 200);
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
}
