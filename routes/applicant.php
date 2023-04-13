<?php

use App\Http\Controllers\Applicant\AcceptedController;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\DispositionDocumentController;
use App\Http\Controllers\Applicant\DocumentController;
use App\Http\Controllers\Applicant\ExitPermitDocumentController;
use App\Http\Controllers\Applicant\LeaveDocumentController;
use App\Http\Controllers\Applicant\NotificationController;
use App\Http\Controllers\Applicant\OutgoingLetterController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\UnitController;
use App\Http\Controllers\Applicant\VerificationController;

Route::group(['prefix' => 'applicant', 'middleware' => 'role:applicant'], function () {
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
    Route::post('/verification/update-approval/{id}', [VerificationController::class, 'update_approval']);
    Route::post('/exit-permit-document/dt', [ExitPermitDocumentController::class, 'dt']);
    Route::post('/leave-document/dt', [LeaveDocumentController::class, 'dt']);
    Route::put('/exit-permit-document/update_approval/{id}', [ExitPermitDocumentController::class, 'update_approval']);
    Route::get('/exit-permit-document/download_pdf/{id}', [ExitPermitDocumentController::class, 'print']);
    Route::get('/leave-document/download_pdf/{id}', [LeaveDocumentController::class, 'print']);
    Route::get('/employee/find', [ApplicantController::class, 'find_employee']);
    Route::get('/unit/find', [UnitController::class, 'find_unit']);
    Route::post('/disposition-document/dt', [DispositionDocumentController::class, 'dt']);
    Route::post('/disposition-update/{id}', [DispositionDocumentController::class, 'update_disposition']);
    Route::get('/disposition-document/download_pdf/{id}', [DispositionDocumentController::class, 'print']);
    Route::post('/outgoing-letter/dt', [OutgoingLetterController::class, 'dt']);

    Route::resource('/done-docs', AcceptedController::class);
    Route::resource('/verification-process', VerificationController::class);
    Route::resource('/document', DocumentController::class);
    Route::resource('/exit-permit-document', ExitPermitDocumentController::class);
    Route::resource('/leave-document', LeaveDocumentController::class);
    Route::resource('/disposition-document', DispositionDocumentController::class);
    Route::resource('/outgoing-letter', OutgoingLetterController::class);
});
