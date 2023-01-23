<?php

/*
|--------------------------------------------------------------------------
| SuiviModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the SuiviModule module have to go in here.
|
*/
use App\Modules\SuiviModule\Http\Controllers\SuiviModuleController;

Route::get('/SuiviCommercial', 'SuiviModuleController@index');
Route::get('/SuiviCommercial/AjoutSuiviEntreprise', 'SuiviModuleController@index');
Route::get('/SuiviCommercial/AjoutSuiviParticulier', 'SuiviModuleController@index');
Route::get('/SuiviCommercial/ModifSuiviParticulier/{ID_SUIVI}', 'SuiviModuleController@index');
Route::get('/SuiviCommercial/ModifSuiviEntreprise/{ID_SUIVI}', 'SuiviModuleController@index');

Route::get('/FormaCampAPI/Suivi', [SuiviModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Suivi/{ID_SUIVI}', [SuiviModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Suivi', [SuiviModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Suivi/{ID_SUIVI}', [SuiviModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Suivi/{ID_SUIVI}', [SuiviModuleController::class, 'Delete'])->middleware('auth');
