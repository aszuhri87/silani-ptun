<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // $user_check = User::select('username')
        // ->whereNull('deleted_at')
        // ->get();

        // foreach ($user_check as $row) {
        //     if ($row->username == $data['username']) {
        //         Alert::error('Username sudah ada!');

        //         return response([
        //             'status' => '400',
        //             'message' => 'Username sudah tersedia!',
        //         ]);
        //     }
        // }

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Applicant::create([
            'name' => $data['name'],
            'user_id' => $user->id,
        ]);

        $user_role = User::where('email', $user->email)->first();

        $user_role->assignRole('applicant');
        // dd($user_role);

        return $user;
    }

    // protected function register(Request $request)
    // {
    //     $input = $request->all();

    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
    //         // if (auth()->user()->applicant_id != null) {
    //         return redirect('applicant/dashboard');
    //     // }
    //     } else {
    //         return redirect()->route('register')
    //             ->with('error', 'Email-Address And Password Are Wrong.');
    //     }
    // }
}
