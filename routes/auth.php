<?php

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'index']);
