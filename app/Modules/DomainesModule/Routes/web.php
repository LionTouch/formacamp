<?php

/*
|--------------------------------------------------------------------------
| DomainesModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the DomainesModule module have to go in here.
|
*/
use App\Modules\DomainesModule\Http\Controllers\DomainesModuleController;
Route::get('/GestionDonnees/Domaines', [DomainesModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/Domaines/{ID_DOMAINE}', [DomainesModuleController::class, 'index'])->middleware('auth');


Route::get('/FormaCampAPI/Domaines', [DomainesModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Domaines/{ID_DOMAINE}', [DomainesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Domaines', [DomainesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Domaines/{ID_DOMAINE}', [DomainesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Domaines/{ID_DOMAINE}', [DomainesModuleController::class, 'Delete'])->middleware('auth');

