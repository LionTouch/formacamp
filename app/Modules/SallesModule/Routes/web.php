<?php

/*
|--------------------------------------------------------------------------
| SallesModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the SallesModule module have to go in here.
|
*/
use App\Modules\SallesModule\Http\Controllers\SallesModuleController;

Route::get('/GestionDonnees/Salles', [SallesModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/Salles/{ID_SALLE}', [SallesModuleController::class, 'index'])->middleware('auth');


Route::get('/FormaCampAPI/Salles', [SallesModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Salles/{ID_SALLE}', [SallesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Salles', [SallesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Salles/{ID_SALLE}', [SallesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Salles/{ID_SALLE}', [SallesModuleController::class, 'Delete'])->middleware('auth');
