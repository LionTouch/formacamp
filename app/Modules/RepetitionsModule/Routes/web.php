<?php

/*
|--------------------------------------------------------------------------
| RepetitionsModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the RepetitionsModule module have to go in here.
|
*/

use App\Modules\RepetitionsModule\Http\Controllers\RepetitionsModuleController;

Route::get('/FormaCampAPI/Repetitions', [RepetitionsModuleController::class, 'List'])->middleware('auth');
