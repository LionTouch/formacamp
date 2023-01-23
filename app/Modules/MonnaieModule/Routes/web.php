<?php

/*
|--------------------------------------------------------------------------
| MonnaieModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the MonnaieModule module have to go in here.
|
*/

use App\Modules\MonnaieModule\Http\Controllers\MonnaieModuleController;

Route::get('/FormaCampAPI/Monnaie', [MonnaieModuleController::class, 'List'])->middleware('auth');
