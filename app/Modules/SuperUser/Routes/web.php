<?php
use App\Modules\SuperUser\Http\Controllers\SuperUserController;

/*
|--------------------------------------------------------------------------
| SuperUser Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the SuperUser module have to go in here.
|
*/
Route::get('/Organismes', [SuperUserController::class, 'index'])->middleware('auth:super');
Route::get('/FormaCampAPIS/Organismes', [SuperUserController::class, 'ListOrganismes'])->middleware('auth:super');
