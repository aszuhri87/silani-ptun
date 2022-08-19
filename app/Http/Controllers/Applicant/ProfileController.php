<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
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
        ->where('applicants.user_id', Auth::guard('admin')->id())
        ->first();

        // dd(Auth::guard('admin')->id());

        return view('applicant.profile.index', ['data' => $data]);
    }

    public function show($id)
    {
        $data = DB::table('applicants')
        ->select('*')
        ->leftJoin('users', 'users.id', 'applicants.user_id')
        ->where('applicants.user_id', $id)
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
            // dd($request->new_password);
            $user = User::where('id', Auth::id());
            $user->update([
                'password' => Hash::make($request->new_password),
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
            // dd($request->new_password);
            $user = Applicant::where('user_id', Auth::id());
            $user->update([
                'address' => $request->address ? $request->address : $user->address,
                'phone_number' => $request->phone_number ? $request->phone_number : $user->phone_number,
                'gender' => $request->gender ? $request->gender : $user->gender,
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

    public function store()
    {
        try {
            $data =
        '[
            {
             "name": "AGUS BUDI SUSILO, S.H.,M.H.",
             "email": "agus_budi_susilo@mahkamahagung.go.id",
             "password": 123456,
             "username": "pegawai1"
            },
            {
             "name": "HENI HENDRARTA WIDYA S K.,S.H.,M.H.",
             "email": "example@mail.com",
             "password": 123457,
             "username": "pegawai2"
            },
            {
             "name": "Hj SITI UMIYATUN, S.H., M.H.",
             "email": "sitiumiyatun@mahkamahagung.go.id",
             "password": 123458,
             "username": "pegawai3"
            },
            {
             "name": "BUDI SURYANA, S.H.",
             "email": "suryana1967@mahkamahagung.go.id",
             "password": 123459,
             "username": "pegawai4"
            },
            {
             "name": "BUDIYONO, S.H.,M.H.",
             "email": "budiyono69@mahkamahagung.go.id",
             "password": 123460,
             "username": "pegawai5"
            },
            {
             "name": "ELLA ROSIANA, S.H., M.H.",
             "email": "ellarosianash@mahkamahagung.go.id",
             "password": 123461,
             "username": "pegawai6"
            },
            {
             "name": "Rr. ASNURI DWI MASTUTI, S.H.",
             "email": "asnuridm@mahkamahagung.go.id",
             "password": 123462,
             "username": "pegawai7"
            },
            {
             "name": "MUJIKARYANTO, S.Pd.",
             "email": "mujikaryanto@mahkamahagung.go.id",
             "password": 123463,
             "username": "pegawai8"
            },
            {
             "name": "SEKAR JAYASARI, S.H.",
             "email": "sekar79@mahkamahagung.go.id ",
             "password": 123464,
             "username": "pegawai9"
            },
            {
             "name": "AGUSTIN ANDRIANI, SH",
             "email": "bundasrtina@mahkamahagung.go.id",
             "password": 123465,
             "username": "pegawai10"
            },
            {
             "name": "RAHMI AFRIZA, SH.M.H",
             "email": "rahmiafriza@mahkamahagung.go.id",
             "password": 123466,
             "username": "pegawai11"
            },
            {
             "name": "LUTHFIE ARDIAN, SH",
             "email": "luthfie@mahkamahagung.go.id",
             "password": 123467,
             "username": "pegawai12"
            },
            {
             "name": "CAHYETI RIYANI,SH",
             "email": "cahyeti.riyani@mahkamahagung.go.id",
             "password": 123468,
             "username": "pegawai13"
            },
            {
             "name": "PRASETYO WIBOWO,SH,MH.",
             "email": "prasetyowibowo@mahkamahagung.go.id",
             "password": 123469,
             "username": "pegawai14"
            },
            {
             "name": "VINARICHA SUCIKA WIBA, S.H.,M.H.",
             "email": "example2@mail.com",
             "password": 123470,
             "username": "pegawai15"
            },
            {
             "name": "MUSLIM, SH",
             "email": "muslimyk@mahkamahagung.go.id",
             "password": 123471,
             "username": "pegawai16"
            },
            {
             "name": "RINI HARYANTI, S.H.",
             "email": "riniharyanti@mahkamahagung.go.id",
             "password": 123472,
             "username": "pegawai17"
            },
            {
             "name": "RAHMAT SUSANTA, S.H.",
             "email": "susanta@mahkamahagung.go.id",
             "password": 123473,
             "username": "pegawai18"
            },
            {
             "name": "RR. TRI ASIH WAHYUDIATI, S.H.,M.Kn",
             "email": "triasih@mahkamahagung.go.id",
             "password": 123474,
             "username": "pegawai19"
            },
            {
             "name": "SOPIAH, SH",
             "email": "sopiah@mahkamahagung.go.id",
             "password": 123475,
             "username": "pegawai20"
            },
            {
             "name": "GANJAR SUPARININGSIH, S.H.",
             "email": "gsupariningsih@mahkamahagung.go.id",
             "password": 123476,
             "username": "pegawai21"
            },
            {
             "name": "RISANG ADE PUTRA, S.H.",
             "email": "risangadeputra@mahkamahagung.go.id",
             "password": 123477,
             "username": "pegawai22"
            },
            {
             "name": "RR.FEMY KRISNANINGTYAS, S.H.",
             "email": "aurelius@mahkamahagung.go.id",
             "password": 123478,
             "username": "pegawai23"
            },
            {
             "name": "ARI NURSETA,SH",
             "email": "arinurseta@mahkamahagung.go.id",
             "password": 123479,
             "username": "pegawai24"
            },
            {
             "name": "ENDAH KRISTIATI, S.H.",
             "email": "endahkristiati@mahkamahagung.go.id",
             "password": 123480,
             "username": "pegawai25"
            },
            {
             "name": "MOHATA",
             "email": "mohata@mahkamahagung.go.id",
             "password": 123481,
             "username": "pegawai26"
            },
            {
             "name": "YULIANTA",
             "email": "tonypandelaki@mahkamahagung.go.id",
             "password": 123482,
             "username": "pegawai27"
            },
            {
             "name": "MUJIYANTA",
             "email": "arinurseta2@mahkamahagung.go.id",
             "password": 123483,
             "username": "pegawai28"
            },
            {
             "name": "RIFIANI RINA MARTIANNA, S.Psi.",
             "email": "r_rina_m@mahkamahagung.go.id",
             "password": 123484,
             "username": "pegawai29"
            },
            {
             "name": "RIRIN HENDARYATI, S.H.",
             "email": "ririnhendaryati@mahkamahagung.go.id",
             "password": 123485,
             "username": "pegawai30"
            },
            {
             "name": "FIERTASARI WINDIYANI, S.E.",
             "email": "fiertasari@mahkamahagung.go.id",
             "password": 123486,
             "username": "pegawai31"
            },
            {
             "name": "IKA WAHYU NOVIANDARI POKKO, SE",
             "email": "ikawahyunoviandaripokko@mahkamahagung.go.id",
             "password": 123487,
             "username": "pegawai32"
            },
            {
             "name": "INDRIYANI WULANDARI, S.E.",
             "email": "indriyani@mahkamahagung.go.id",
             "password": 123488,
             "username": "pegawai33"
            },
            {
             "name": "DEDIANTO RAMALI, S.H.",
             "email": "dediramali@mahkamahagung.go.id",
             "password": 123489,
             "username": "pegawai34"
            },
            {
             "name": "SRI SUMIYATUNNINGSIH, A.Md.",
             "email": "ssn0212@mahkamahagung.go.id",
             "password": 123490,
             "username": "pegawai35"
            },
            {
             "name": "ROSIANI, S.H.",
             "email": "rosiani@mahkamahagung.go.id",
             "password": 123491,
             "username": "pegawai36"
            },
            {
             "name": "ENDANG SRI KASTUTIK",
             "email": "endang.srikastutik@mahkamahagung.go.id",
             "password": 123492,
             "username": "pegawai37"
            },
            {
             "name": "DWI RACHMAD ADHI W.P., S.Ak",
             "email": "dwirachmad@mahkamahagung.go.id",
             "password": 123493,
             "username": "pegawai38"
            },
            {
             "name": "EKO BUDI PRASTYO, S.E.",
             "email": "ekobprastyo@mahkamahagung.go.id",
             "password": 123494,
             "username": "pegawai39"
            },
            {
             "name": "QORRY AINI HANI,S.AK",
             "email": "qorryainihani@mahkamahagung.go.id",
             "password": 123495,
             "username": "pegawai40"
            },
            {
             "name": "BARIQ AZMI RIZALDY ,A.Md",
             "email": "bariqazmi@mahkamahagung.go.id",
             "password": 123496,
             "username": "pegawai41"
            },
            {
             "name": "KHAIRIL AMAR, S.H.",
             "email": "khamar1512@gmail.com",
             "password": 123497,
             "username": "pegawai42"
            },
            {
             "name": "DALIMIN",
             "email": "dalimin@mahkamahagung.go.id",
             "password": 123498,
             "username": "pegawai43"
            },
            {
             "name": "SUHARTONO",
             "email": "suhartono1967@mahkamahagung.go.id",
             "password": 123499,
             "username": "pegawai44"
            }
        ]';

            foreach (json_decode($data) as $d) {
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
}
