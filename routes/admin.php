<?php

use App\Http\Controllers\Admin\AcceptedController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\DispositionDocumentController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentCategoryRequirementController;
use App\Http\Controllers\Admin\DocumentRequirementController;
use App\Http\Controllers\Admin\ExitPermitDocumentController;
use App\Http\Controllers\Admin\GeneralApplicantController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\LeaveDocumentController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OutgoingLetterController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RequirementTypeController;
use App\Http\Controllers\Admin\SubUnitController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\VerificationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|super admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/download_format', [ApplicantController::class, 'download_format']);
    Route::post('/notification/dt', [NotificationController::class, 'dt']);
    Route::post('/profile/update_password', [ProfileController::class, 'update_password']);
    Route::post('/profile/update_profile', [ProfileController::class, 'update_profile']);
    Route::post('/list-applicant/dt', [ApplicantController::class, 'dt']);
    Route::get('/employee/find', [ApplicantController::class, 'find_employee']);
    Route::get('/unit/find', [UnitController::class, 'find_unit']);

    Route::post('/manage-admin/dt', [ManageAdminController::class, 'dt']);
    Route::post('/accepted/dt', [AcceptedController::class, 'dt']);
    Route::post('/verification/dt', [VerificationController::class, 'dt']);
    Route::get('/verification/download/{id}', [VerificationController::class, 'download']);
    Route::post('/inbox/dt', [InboxController::class, 'dt']);
    Route::post('/document-category/dt', [DocumentCategoryController::class, 'dt']);
    Route::post('/sub-unit/dt', [SubUnitController::class, 'dt']);
    Route::post('/unit/dt', [UnitController::class, 'dt']);
    Route::post('/req-type/dt', [RequirementTypeController::class, 'dt']);
    Route::post('/document-category-req/dt', [DocumentCategoryRequirementController::class, 'dt']);
    Route::post('/document-req/dt', [DocumentRequirementController::class, 'dt']);
    Route::post('/exit-permit-document/dt', [ExitPermitDocumentController::class, 'dt']);
    Route::post('/leave-document/dt', [LeaveDocumentController::class, 'dt']);
    Route::post('/applicant/import', [ApplicantController::class, 'import']);
    Route::get('/exit-permit-document/download_pdf/{id}', [ExitPermitDocumentController::class, 'print']);
    Route::post('/disposition-document/dt', [DispositionDocumentController::class, 'dt']);
    Route::get('/disposition-document/download_pdf/{id}', [DispositionDocumentController::class, 'print']);
    Route::post('/outgoing-letter/dt', [OutgoingLetterController::class, 'dt']);
    Route::put('/exit-permit-document/update_approval/{id}', [ExitPermitDocumentController::class, 'update_approval']);
    Route::get('/exit-permit-document/download_pdf/{id}', [ExitPermitDocumentController::class, 'print']);
    Route::get('/leave-document/download_pdf/{id}', [LeaveDocumentController::class, 'print']);

    Route::get('/list-general-applicant/{id}', [GeneralApplicantController::class, 'show']);
    Route::post('/list-general-applicant/dt', [GeneralApplicantController::class, 'dt']);
    Route::delete('/list-general-applicant/{id}', [GeneralApplicantController::class, 'destroy']);

    Route::resource('/notification', NotificationController::class);
    Route::resource('/manage-admin', ManageAdminController::class);
    Route::resource('/accepted', AcceptedController::class);
    Route::resource('/verification', VerificationController::class);
    Route::resource('/inbox', InboxController::class);
    Route::resource('/document-category-req', DocumentCategoryRequirementController::class);
    Route::resource('/document-req', DocumentRequirementController::class);
    Route::resource('/sub-unit', SubUnitController::class);
    Route::resource('/document-category', DocumentCategoryController::class);
    Route::resource('/unit', UnitController::class);
    Route::resource('/req-type', RequirementTypeController::class);
    Route::resource('/list-applicant', ApplicantController::class);
    Route::resource('/exit-permit-document', ExitPermitDocumentController::class);
    Route::resource('/leave-document', LeaveDocumentController::class);
    Route::resource('/disposition-document', DispositionDocumentController::class);
    Route::resource('/outgoing-letter', OutgoingLetterController::class);
    Route::resource('/list-general-applicant', GeneralApplicantController::class);

}
);
