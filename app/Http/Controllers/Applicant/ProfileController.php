<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Libraries\PageLib;
use App\Models\Applicant;
use App\Models\Signature;
use App\Models\User;
use Exception;
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
        $data = DB::table('applicants')
        ->select('*')
        ->join('users', 'users.id', 'applicants.user_id')
        ->where('applicants.user_id', Auth::user()->id)
        ->first();

        $signature = DB::table('signatures')
        ->select('photo')
        ->where('user_id', Auth::user()->id)
        ->first();

        if ($signature) {
            $data->signature = $signature->photo;
        } else {
            $data->signature = null;
        }

        return view('applicant.profile.index', ['data' => $data], PageLib::config([]));
    }

    public function show($id)
    {
        $data = DB::table('applicants')
        ->select('*')
        ->leftJoin('users', 'users.id', 'applicants.user_id')
        ->where('applicants.user_id', $id)
        ->first();

        $signature = DB::table('signatures')
        ->select('photo')
        ->where('user_id', Auth::user()->id)
        ->first();

        if ($signature) {
            $data->signature = $signature->photo;
        } else {
            $data->signature = null;
        }

        return Response::json($data);
    }

    public function update_profile(Request $request)
    {
        try {
            $user = User::where('id', Auth::id());
            $user->update([
                'email' => $request->email ? $request->email : $user->email,
                'username' => $request->username ? $request->username : $user->username,
                'name' => $request->name ? $request->name : $user->name,
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = $file->getClientOriginalName();
                $file->move(public_path().'/files/', $file_name);
            }

            $appl = Applicant::where('user_id', Auth::id());

            $appl->update([
                'name' => $request->name ? $request->name : $appl->name,
                'image' => $file_name ? $file_name : $appl->image,
                'nik' => $request->nik ? $request->nik : $appl->nik,
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
                'password' => Hash::make($request->new_password) ? Hash::make($request->new_password) : $user->password,
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

    public function update_info(Request $request)
    {
        try {
            $user = Applicant::where('user_id', Auth::id());
            $user->update([
                'address' => $request->address ? $request->address : $user->address,
                'phone_number' => $request->phone_number ? $request->phone_number : $user->phone_number,
                'gender' => $request->gender ? $request->gender : $user->gender,
            ]);

            if ($request->gol) {
                $user->update([
                    'gol' => $request->gol ? $request->gol : $user->gol,
                ]);
            }

            if ($request->nip) {
                $user->update([
                    'nip' => $request->nip ? $request->nip : $user->nip,
                ]);
            }

            if ($request->hasFile('signature')) {
                $sign_file = $request->file('signature');
                $sign_file_name = $sign_file->getClientOriginalName();
                $sign_file->move(public_path().'/signature/', $sign_file_name);
            }

            $signature = Signature::where('user_id', Auth::user()->id);

            if (!$signature->first()) {
                Signature::create([
                    'photo' => $sign_file_name,
                    'user_id' => Auth::user()->id,
                ]);
            } else {
                $signature->update([
                    'photo' => $sign_file_name ? $sign_file_name : $signature->photo,
                ]);
            }

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

    public function store()
    {
        try {
            $user = User::create([
                'name' => $d->name,
                'username' => $d->username,
                'email' => $d->email,
                'password' => Hash::make($d->password),
            ]);

            Applicant::create([
                'name' => $d->name,
                'user_id' => $user->id,
            ]);

            $user_role = User::where('email', $user->email)->first();

            $user_role->assignRole('applicant');

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
}
