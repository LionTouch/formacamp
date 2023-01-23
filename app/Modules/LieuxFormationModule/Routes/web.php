<?php

/*
|--------------------------------------------------------------------------
| LieuxFormationModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the LieuxFormationModule module have to go in here.
|
*/
use App\Modules\LieuxFormationModule\Http\Controllers\LieuxFormationModuleController;

Route::get('/GestionDonnees/LieuxDeFormation', 'LieuxFormationModuleController@index');
Route::get('/GestionDonnees/AjoutLieuxDeFormation', 'LieuxFormationModuleController@index');
Route::get('/GestionDonnees/ModifLieuxDeFormation/{ID_LIEU}', 'LieuxFormationModuleController@index');

Route::get('/FormaCampAPI/LieuxDeFormation', [LieuxFormationModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/LieuxDeFormation/{ID_LIEU}', [LieuxFormationModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/LieuxDeFormation', [LieuxFormationModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/LieuxDeFormation/{ID_LIEU}', [LieuxFormationModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/LieuxDeFormation/{ID_LIEU}', [LieuxFormationModuleController::class, 'Delete'])->middleware('auth');

