<?php

/*
|--------------------------------------------------------------------------
| DiplomesModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the DiplomesModule module have to go in here.
|
*/
use App\Modules\DiplomesModule\Http\Controllers\DiplomesModuleController;
Route::get('/GestionDonnees/Diplomes', [DiplomesModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/Diplomes/{ID_DIPLOME}', [DiplomesModuleController::class, 'index'])->middleware('auth');


Route::get('/FormaCampAPI/Diplomes', [DiplomesModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Diplomes/{ID_DIPLOME}', [DiplomesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Diplomes', [DiplomesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Diplomes/{ID_DIPLOME}', [DiplomesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Diplomes/{ID_DIPLOME}', [DiplomesModuleController::class, 'Delete'])->middleware('auth');

