<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = DB::table('admins')
        ->select('*')
        ->join('users', 'users.id', 'admins.user_id')
        ->where('admins.user_id', Auth::guard('admin')->id())
        ->orWhere('admins.user_id', Auth::guard('super-admin')->id())
        ->first();

        $unit = DB::table('units')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        return view('admin.profile.index', PageLib::config([]), ['data' => $data, 'unit' => $unit]);
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

    public function update_profile(Request $request)
    {
        try {
            // dd($request->new_password);
            $user = User::where('id', Auth::id());
            $user->update([
                'email' => $request->email ? $request->email : $user->first()->email,
                'username' => $request->username ? $request->username : $user->first()->username,
                'name' => $request->name ? $request->name : $user->first()->name,
            ]);

            $admin = Admin::where('user_id', Auth::id());
            $admin->update([
                'name' => $request->name ? $request->name : $user->first()->name,
                'unit_id' => $request->select_unit ? $request->select_unit : $admin->first()->unit_id,
            ]);

            return response([
                'data' => $user,
                'message' => 'Data Terubah',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_password(Request $request)
    {
        try {
            $user = User::where('id', Auth::id());
            $user->update([
                'password' => Hash::make($request->new_password) ? Hash::make($request->new_password) : $user->first()->password,
            ]);

            return response([
                'data' => $user,
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
