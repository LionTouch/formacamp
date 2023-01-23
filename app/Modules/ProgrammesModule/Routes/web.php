<?php

/*
|--------------------------------------------------------------------------
| ProgrammesModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the ProgrammesModule module have to go in here.
|
*/

use App\Modules\ProgrammesModule\Http\Controllers\ProgrammesModuleController;

Route::get('/Bibliotheque/Programmes', [ProgrammesModuleController::class, 'index'])->middleware('auth');
Route::get('/Bibliotheque/Programmes/Ajout', [ProgrammesModuleController::class, 'index'])->middleware('auth');
Route::get('/Bibliotheque/Programmes/{ID_PROGRAMME}', [ProgrammesModuleController::class, 'index'])->middleware('auth');


Route::get('/FormaCampAPI/Programmes',[ProgrammesModuleController::class,'List'])->middleware('auth');
Route::get('/FormaCampAPI/Programmes/Session/{ID_SESSION}',[ProgrammesModuleController::class,'GetBySession'])->middleware('auth');
Route::get('/FormaCampAPI/Programmes/{ID_PROGRAMME}', [ProgrammesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Programmes', [ProgrammesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Programmes/{ID_PROGRAMME}', [ProgrammesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Programmes/{ID_PROGRAMME}', [ProgrammesModuleController::class, 'Delete'])->middleware('auth');
