<?php

use App\Http\Controllers\Applicant\AcceptedController;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\DocumentController;
use App\Http\Controllers\Applicant\NotificationController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\VerificationController;

Route::group(['prefix' => 'applicant', 'middleware' => 'role:applicant'], function () {
    // Route::get('/mail', [MailController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified');
    Route::get('/profile', [ProfileController::class, 'index'])->middleware('verified');
    Route::resource('/profile', ProfileController::class);
    Route::get('/notification', [NotificationController::class, 'index'])->middleware('verified');
    Route::post('/profile/update_password', [ProfileController::class, 'update_password']);
    Route::post('/profile/update_profile', [ProfileController::class, 'update_profile']);
    Route::post('/profile/update_info', [ProfileController::class, 'update_info']);

    Route::post('/done-docs/dt', [AcceptedController::class, 'dt']);
    Route::get('/document/download/{id}', [DocumentController::class, 'download']);
    Route::post('/document/dt', [DocumentController::class, 'dt']);
    Route::get('/document/edit/{id}', [DocumentController::class, 'show']);
    Route::post('/document/edit/{id}', [DocumentController::class, 'update']);
    Route::get('/document-select/{id}', [DocumentController::class, 'get_category']);
    Route::get('/done-docs/dt', [AcceptedController::class, 'get_category']);
    Route::post('/verification-process/dt', [VerificationController::class, 'dt']);
    Route::resource('/done-docs', AcceptedController::class);
    Route::resource('/verification-process', VerificationController::class);
    Route::resource('/document', DocumentController::class);
}
);
