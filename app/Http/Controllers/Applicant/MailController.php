<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function index()
    {
        return view('applicant.mail.index');
    }
}
