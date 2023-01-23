<?php

/*
|--------------------------------------------------------------------------
| StagiairesModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the StagiairesModule module have to go in here.
|
*/
use App\Modules\StagiairesModule\Http\Controllers\StagiairesModuleController;

Route::get('/GestionDonnees/Stagiaires', 'StagiairesModuleController@index');
Route::get('/GestionDonnees/AjoutStagiaires', 'StagiairesModuleController@index');
Route::get('/GestionDonnees/ModifStagiaires/{ID_STAGIAIRE}', 'StagiairesModuleController@index');

Route::get('/FormaCampAPI/Stagiaires', [StagiairesModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Stagiaires/{ID_STAGIAIRE}', [StagiairesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Stagiaires', [StagiairesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Stagiaires/{ID_STAGIAIRE}', [StagiairesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Stagiaires/{ID_STAGIAIRE}', [StagiairesModuleController::class, 'Delete'])->middleware('auth');

