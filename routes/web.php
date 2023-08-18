<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
include base_path('routes/admin.php');
include base_path('routes/applicant.php');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
Route::post('/import', [App\Http\Controllers\Applicant\ProfileController::class, 'store']);
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout']);
