<?php

/*
|--------------------------------------------------------------------------
| CompteModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the CompteModule module have to go in here.
|
*/
use App\Modules\CompteModule\Http\Controllers\CompteModuleController;
use App\Modules\CompteModule\Http\Controllers\CompteAccesModuleController;
use App\Modules\CompteModule\Http\Controllers\CompteAccesCategorieModuleController;

Route::get('/GestionCompte/Profil', [CompteModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionCompte/Profil/{ID_USER}', [CompteModuleController::class, 'index'])->middleware(['auth','can:updateProfile,ID_USER']);

Route::get('/FormaCampAPI/Profil/Get/{ID_USER}', [CompteModuleController::class, 'Get'])->middleware(['auth','can:updateProfile,ID_USER']);


Route::get('/GestionCompte/CompteAcces/{ID_USER}', [CompteModuleController::class, 'index'])->middleware('auth');
//Route::get('/GestionCompte/AjoutCompteAcces', [CompteModuleController::class, 'index'])->middleware('auth');
//Route::get('/GestionCompte/ModifCompteAcces/{ID_ACCES}', [CompteModuleController::class, 'index'])->middleware('auth');

Route::get('/FormaCampAPI/CompteAcces/{ID_USER}', [CompteAccesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/CompteAcces', [CompteAccesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/CompteAcces/{ID_USER}', [CompteAccesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/CompteAcces/{ID_USER}', [CompteAccesModuleController::class, 'Delete'])->middleware('auth');

Route::get('/FormaCampAPI/CompteAccesFormateur/{ID_USER}', [CompteAccesModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/CompteAccesFormateur', [CompteAccesModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/CompteAccesFormateur/{ID_USER}', [CompteAccesModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/CompteAccesFormateur/{ID_USER}', [CompteAccesModuleController::class, 'Delete'])->middleware('auth');

Route::get('/FormaCampAPI/CompteAccesCategorie', [CompteAccesCategorieModuleController::class, 'List'])->middleware('auth');





Route::get('/GestionCompte/MonAbonnement', [CompteModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionCompte/Extranet', [CompteModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionCompte/CatalogueEnLigne', [CompteModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionCompte/ModelesDeDocuments', [CompteModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionCompte/ModelesEmails', [CompteModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionCompte/ModelesListeTaches', [CompteModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionCompte/GestionCompetences', [CompteModuleController::class, 'index'])->middleware('auth');


