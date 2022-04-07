<?php

use App\Http\Controllers\Admin\AcceptedMailController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VerificationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/inbox', [InboxController::class, 'index']);
    Route::get('/accepted-mail', [AcceptedMailController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/verification-1', [VerificationController::class, 'verification_1']);
}
);
