<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // protected function login(Request $request)
    // {
    //     $input = $request->all();

    //     $this->validate($request, [
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     return redirect()->route('login')
    //             ->with('error', 'Email-Address And Password Are Wrong.');
    // }

    public function username()
    {
        return 'username';
    }

    protected function authenticated(Request $request, $user)
    {
        $user_dt = $user->with('roles')->where('username', $request->username)->first();
        if ($user->hasRole('admin')) {
            Alert::toast('Selamat Datang, '.$user_dt->name.'!', 'success');

            return redirect('admin/dashboard');
        } elseif ($user->hasRole('super admin')) {
            Alert::toast('Selamat Datang, '.$user_dt->name.'!', 'success');

            return redirect('admin/dashboard');
        } elseif ($user->hasRole('applicant')) {
            Alert::toast('Selamat Datang, '.$user_dt->name.'!', 'success');

            return redirect('applicant/dashboard');
        } else {
            Alert::error('Gagal', 'Email atau password salah!');

            return redirect()->route('login')
                ->with('error', 'Email-Address And Password Are Wrong.');
        }
    }
}
