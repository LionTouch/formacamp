<?php

/*
|--------------------------------------------------------------------------
| LanguesModules Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the LanguesModules module have to go in here.
|
*/
use App\Modules\LanguesModules\Http\Controllers\LanguesModulesController;

Route::get('/FormaCampAPI/Langues', [LanguesModulesController::class, 'List'])->middleware('auth');
