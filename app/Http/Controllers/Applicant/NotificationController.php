<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        return view('applicant.notification.index');
    }
}
