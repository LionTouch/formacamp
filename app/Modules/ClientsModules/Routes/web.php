<?php

/*
|--------------------------------------------------------------------------
| ClientsModules Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the ClientsModules module have to go in here.
|
*/

use App\Modules\ClientsModules\Http\Controllers\ClientsModulesController;
use App\Modules\ClientsModules\Http\Controllers\ClientsTypeModulesController;

Route::get('/GestionDonnees/Clients', 'ClientsModulesController@index');
Route::get('/GestionDonnees/AjoutClients', 'ClientsModulesController@index');
Route::get('/GestionDonnees/ModifClients/{ID_CLIENT}', 'ClientsModulesController@index');

Route::get('/FormaCampAPI/Clients', [ClientsModulesController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Clients/{ID_CLIENT}', [ClientsModulesController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Clients', [ClientsModulesController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Clients/{ID_CLIENT}', [ClientsModulesController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Clients/{ID_CLIENT}', [ClientsModulesController::class, 'Delete'])->middleware('auth');



Route::get('/FormaCampAPI/ClientsType', [ClientsTypeModulesController::class, 'List'])->middleware('auth');
