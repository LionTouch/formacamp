<?php

/*
|--------------------------------------------------------------------------
| CivilitesModules Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the CivilitesModules module have to go in here.
|
*/
use App\Modules\CivilitesModules\Http\Controllers\CivilitesModulesController;

Route::get('/FormaCampAPI/Civilites', [CivilitesModulesController::class, 'List'])->middleware('auth');
