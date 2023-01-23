<?php

/*
|--------------------------------------------------------------------------
| FinanceursExternesModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the FinanceursExternesModule module have to go in here.
|
*/
use App\Modules\FinanceursExternesModule\Http\Controllers\FinanceursExternesModuleController;

Route::get('/GestionDonnees/FinanceursExternes', 'FinanceursExternesModuleController@index');
Route::get('/GestionDonnees/AjoutFinanceursExternes', 'FinanceursExternesModuleController@index');
Route::get('/GestionDonnees/ModifFinanceursExternes/{ID_FINANCEUR}', 'FinanceursExternesModuleController@index');

Route::get('/FormaCampAPI/FinanceursExternes', [FinanceursExternesModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/FinanceursExternes/{ID_FINANCEUR}', [FinanceursExternesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/FinanceursExternes', [FinanceursExternesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/FinanceursExternes/{ID_FINANCEUR}', [FinanceursExternesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/FinanceursExternes/{ID_FINANCEUR}', [FinanceursExternesModuleController::class, 'Delete'])->middleware('auth');
