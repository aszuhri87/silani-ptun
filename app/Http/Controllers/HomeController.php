<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $app = Applicant::select('*')->where('user_id', Auth::id())->first();
            $admin = Admin::select('*')->where('user_id', Auth::id())->first();

            if ($app->user_id == Auth::id()) {
                Alert::toast('Selamat Datang '.Auth::user()->username.'!', 'success');

                return redirect('/applicant/dashboard');
            } elseif ($admin->user_id == Auth::id()) {
                Alert::toast('Selamat Datang '.Auth::user()->username.'!', 'success');

                return view('admin.dashboard.index');
            }
        } else {
            Alert::error('error', 'Akun tidak dikenali!');

            return redirect('login')->withErrors('error', 'Akun tidak dikenali!');
        }
    }
}
