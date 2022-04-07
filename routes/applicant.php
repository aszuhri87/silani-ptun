<?php

use App\Http\Controllers\Applicant\MailController;

Route::group(['prefix' => 'applicant'], function () {
    Route::get('/mail', [MailController::class, 'index']);
}
);
