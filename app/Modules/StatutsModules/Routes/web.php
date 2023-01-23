<?php

/*
|--------------------------------------------------------------------------
| StatutsModules Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the StatutsModules module have to go in here.
|
*/

use App\Modules\StatutsModules\Http\Controllers\StatutsModulesController;

Route::get('/FormaCampAPI/Statuts', [StatutsModulesController::class, 'List'])->middleware('auth');
