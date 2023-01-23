<?php

/*
|--------------------------------------------------------------------------
| TypeTarifModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the TypeTarifModule module have to go in here.
|
*/
use App\Modules\TypeTarifModule\Http\Controllers\TypeTarifModuleController;

Route::get('/FormaCampAPI/TypeTarif', [TypeTarifModuleController::class, 'List'])->middleware('auth');
