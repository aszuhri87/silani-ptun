<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
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

        return view('admin.profile.index', ['data' => $data, 'unit' => $unit]);
    }

    public function show($id)
    {
        $data = DB::table('admins')
        ->select('*')
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
                'email' => $request->email ? $request->email : $user->email,
                'username' => $request->username ? $request->username : $user->username,
                'name' => $request->name ? $request->name : $user->name,
            ]);

            Admin::where('user_id', Auth::id())
            ->update([
                'name' => $request->name ? $request->name : $user->name,
                'unit_id' => $request->select_unit ? $request->select_unit : $user->unit_id,
            ]);

            Alert::success('Berhasil', 'Data berhasil diubah!');

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
            // dd($request->new_password);
            $user = User::where('id', Auth::id());
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            Alert::success('Berhasil', 'Data berhasil diubah!');

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
