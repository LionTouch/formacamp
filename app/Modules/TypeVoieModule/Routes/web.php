<?php

/*
|--------------------------------------------------------------------------
| TypeVoieModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the TypeVoieModule module have to go in here.
|
*/
use App\Modules\TypeVoieModule\Http\Controllers\TypeVoieModuleController;

Route::get('/FormaCampAPI/TypeVoie', [TypeVoieModuleController::class, 'List'])->middleware('auth');
