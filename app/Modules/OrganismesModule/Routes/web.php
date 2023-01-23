<?php

/*
|--------------------------------------------------------------------------
| OrganismesModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the OrganismesModule module have to go in here.
|
*/
use App\Modules\OrganismesModule\Http\Controllers\OrganismesModuleController;

Route::get('/GestionDonnees/Organismes', 'OrganismesModuleController@index');
Route::get('/GestionDonnees/AjoutOrganismes', 'OrganismesModuleController@index');
Route::get('/GestionDonnees/ModifOrganismes/{ID_ORGANISME}', 'OrganismesModuleController@index');


Route::get('/FormaCampAPI/Organismes', [OrganismesModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Organismes/{ID_ORGANISME}', [OrganismesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Organismes', [OrganismesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Organismes/{ID_ORGANISME}', [OrganismesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Organismes/{ID_ORGANISME}', [OrganismesModuleController::class, 'Delete'])->middleware('auth');


