<?php

/*
|--------------------------------------------------------------------------
| FormateursModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the FormateursModule module have to go in here.
|
*/

use App\Modules\FormateursModule\Http\Controllers\FormateursModuleController;
use App\Modules\FormateursModule\Http\Controllers\StatutsFormateursModuleController;
use App\Modules\FormateursModule\Http\Controllers\DocsFormateursModuleController;

Route::get('/GestionDonnees/Formateurs', 'FormateursModuleController@index');
Route::get('/GestionDonnees/AjoutFormateurs', 'FormateursModuleController@index');
Route::get('/GestionDonnees/ModifFormateurs/{ID_FORMATEUR}', 'FormateursModuleController@index');

Route::get('/FormaCampAPI/Formateurs', [FormateursModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Formateurs/{ID_FORMATEUR}', [FormateursModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Formateurs', [FormateursModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Formateurs/{ID_FORMATEUR}', [FormateursModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Formateurs/{ID_FORMATEUR}', [FormateursModuleController::class, 'Delete'])->middleware('auth');

Route::get('/FormaCampAPI/StatutsFormateurs', [StatutsFormateursModuleController::class, 'List'])->middleware('auth');
Route::delete('/FormaCampAPI/StatutsFormateurs/{ID_STATUT}', [StatutsFormateursModuleController::class, 'Delete'])->middleware('auth');

Route::put('/FormaCampAPI/DocsFormateurs/{ID_DOC}', [DocsFormateursModuleController::class, 'Update'])->middleware('auth');
Route::get('/FormaCampAPI/DocsFormateurs', [DocsFormateursModuleController::class, 'List'])->middleware('auth');
Route::delete('/FormaCampAPI/DocsFormateurs/{ID_DOC}', [DocsFormateursModuleController::class, 'Delete'])->middleware('auth');
