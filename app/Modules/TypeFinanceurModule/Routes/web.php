<?php

/*
|--------------------------------------------------------------------------
| TypeFinanceurModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the TypeFinanceurModule module have to go in here.
|
*/

use App\Modules\TypeFinanceurModule\Http\Controllers\TypeFinanceurModuleController;

Route::get('/FormaCampAPI/TypeFinanceur', [TypeFinanceurModuleController::class, 'List'])->middleware('auth');
