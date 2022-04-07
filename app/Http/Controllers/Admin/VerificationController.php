<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function verification_1()
    {
        return view('admin.verification.index');
    }
}
