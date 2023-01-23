<?php

/*
|--------------------------------------------------------------------------
| FormeJuridiqueModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the FormeJuridiqueModule module have to go in here.
|
*/

use App\Modules\FormeJuridiqueModule\Http\Controllers\FormeJuridiqueModuleController;

Route::get('/FormaCampAPI/FormJuridique', [FormeJuridiqueModuleController::class, 'List'])->middleware('auth');
