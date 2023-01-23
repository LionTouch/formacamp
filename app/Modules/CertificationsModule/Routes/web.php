<?php

/*
|--------------------------------------------------------------------------
| CertificationsModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the CertificationsModule module have to go in here.
|
*/

use App\Modules\CertificationsModule\Http\Controllers\CertificationsModuleController;

Route::get('/FormaCampAPI/Certifications', [CertificationsModuleController::class, 'List'])->middleware('auth');
Route::post('/FormaCampAPI/Certifications', [CertificationsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Certifications/{ID_CERTIF}', [CertificationsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Certifications/{ID_CERTIF}', [CertificationsModuleController::class, 'Delete'])->middleware('auth');
