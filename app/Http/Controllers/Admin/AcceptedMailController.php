<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AcceptedMailController extends Controller
{
    public function index()
    {
        return view('admin.accepted.index');
    }
}
