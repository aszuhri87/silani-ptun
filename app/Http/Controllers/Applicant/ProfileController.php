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
                'email' => $request->email ? $request->email : $user->first()->email,
                'username' => $request->username ? $request->username : $user->first()->username,
                'name' => $request->name ? $request->name : $user->first()->name,
            ]);

            if ($request->no_image = 'true') {
                $file_name = null;
                $action = $request->no_image;
            }
            // dd($request->file('image'));

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->extension();

                if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'){
                    $file_name = date('Y-m-d_s') . '.' . $ext;
                    $file->move(public_path() . '/files/', $file_name);
                    $action = $request->hasFile('image');
                } else {
                    return response([
                        'message' => "File harus jpg, jpeg, png",
                    ], 400);
                }
            }

            $appl = Applicant::where('user_id', Auth::id());
            $appl->update([
                'name' => $request->name ? $request->name : $appl->first()->name,
                'image' => $action ? $file_name : $appl->first()->image,
                'nik' => $request->nik ? $request->nik : $appl->first()->nik,
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

    public function update_info(Request $request)
    {
        try {
            $user = Applicant::where('user_id', Auth::id());
            $users = User::where('id', Auth::id());

            $user->update([
                'address' => $request->address ? $request->address : $user->first()->address,
                'phone_number' => $request->phone_number ? $request->phone_number : $user->first()->phone_number,
                'gender' => $request->gender ? $request->gender : $user->first()->gender,
            ]);

            if ($request->gol) {
                $users->update([
                    'gol' => $request->gol ? $request->gol : $users->first()->gol,
                ]);
            }

            if ($request->nip) {
                $users->update([
                    'nip' => $request->nip ? $request->nip : $users->first()->nip,
                ]);
            }

            if ($request->hasFile('signature')) {
                $sign_file = $request->file('signature');
                $sign_file_name = $sign_file->getClientOriginalName();
                $sign_file->move(public_path() . '/signature/', $sign_file_name);
            }

            $signature = Signature::where('user_id', Auth::user()->id);

            if (!$signature->first()) {
                Signature::create([
                    'photo' => $request->hasFile('signature') ? $sign_file_name : $signature->first()->photo,
                    'user_id' => Auth::user()->id,
                ]);
            } else {
                $signature->update([
                    'photo' => $request->hasFile('signature') ? $sign_file_name : $signature->first()->photo,
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
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Applicant::create([
                'name' => $request->name,
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
