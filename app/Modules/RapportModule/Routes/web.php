<?php
use App\Modules\RapportModule\Http\Controllers\SuiviDevisController;
use App\Modules\RapportModule\Http\Controllers\SuiviFacturesController;
use App\Modules\RapportModule\Http\Controllers\SuiviActivitesController;
use App\Modules\RapportModule\Http\Controllers\SuiviPedagogiquesController;
/*
|--------------------------------------------------------------------------
| RapportModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the RapportModule module have to go in here.
|
*/
Route::get('/RapportActivite/SuiviDevis', 'RapportModuleController@index');
Route::get('/FormaCampAPI/SuiviDevis', [SuiviDevisController::class, 'List'])->middleware('auth');

Route::get('/RapportActivite/SuiviFactures', 'RapportModuleController@index');
Route::get('/FormaCampAPI/SuiviFactures', [SuiviFacturesController::class, 'List'])->middleware('auth');

Route::get('/RapportActivite/SuiviActivite', 'RapportModuleController@index');
Route::get('/FormaCampAPI/SuiviActivite', [SuiviActivitesController::class, 'List'])->middleware('auth');

Route::get('/RapportActivite/BilanPedagogique', 'RapportModuleController@index');
Route::get('/FormaCampAPI/BilanPedagogique', [SuiviPedagogiquesController::class, 'List'])->middleware('auth');
