<?php

/*
|--------------------------------------------------------------------------
| ActionsFormationModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the ActionsFormationModule module have to go in here.
|
*/
use App\Modules\ActionsFormationModule\Http\Controllers\ActionsFormationModuleController;
Route::get('/GestionDonnees/Actions', [ActionsFormationModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/Actions/{ID_ACTION}', [ActionsFormationModuleController::class, 'index'])->middleware('auth');


Route::get('/FormaCampAPI/Actions', [ActionsFormationModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Actions/{ID_ACTION}', [ActionsFormationModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Actions', [ActionsFormationModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Actions/{ID_ACTION}', [ActionsFormationModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Actions/{ID_ACTION}', [ActionsFormationModuleController::class, 'Delete'])->middleware('auth');


