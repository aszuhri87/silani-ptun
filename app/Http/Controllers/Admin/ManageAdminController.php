<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ManageAdminController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = DB::table('admins')
        ->select('*')
        ->leftJoin('users', 'users.id', 'admins.user_id')
        ->get();

        $unit = DB::table('units')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        return view('admin.admin_management.index', PageLib::config([]), ['data' => $data, 'unit' => $unit]);
    }

    public function dt()
    {
        $data = DB::table('admins')
        ->select([
            'admins.name',
            'users.username',
            'users.email',
            'users.id',
            'admins.unit_id',
            'units.name as unit',
            ])
        ->leftJoin('users', 'users.id', 'admins.user_id')
        ->leftJoin('units', 'units.id', 'admins.unit_id')
        ->whereNull('admins.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function show($id)
    {
        $data = DB::table('admins')
        ->select('admins.unit_id', '*')
        ->leftJoin('users', 'users.id', 'admins.user_id')
        ->where('admins.user_id', $id)
        ->first();

        return Response::json($data);
    }

    public function store(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                ]);
                $data = Admin::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                    'unit_id' => $request->select_unit,
                ]);

                $user_role = User::where('username', $user->username)->first();

                $user_role->assignRole('admin');

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
            $result = DB::transaction(function () use ($request,$id) {
                $data = User::find($id);
                $data->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->new_password) ? Hash::make($request->new_password) : $user->password,
                ]);

                $user = Admin::where('user_id', $id);
                $user->update([
                    'name' => $request->name,
                    'unit_id' => $request->select_unit ? $request->select_unit : $user->unit_id,
                ]);

                return $data;
            });

            return response([
                'data' => $result,
                'message' => 'Data Terubah',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_password(Request $request, $id)
    {
        try {
            $user = User::where('id', $id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response([
                'data' => $data,
                'message' => 'Data Terubah',
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
}
