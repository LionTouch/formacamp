<?php

/*
|--------------------------------------------------------------------------
| AdminsModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the AdminsModule module have to go in here.
|
*/
use App\Modules\AdminsModule\Http\Controllers\AdminsModuleController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
Route::get('/GestionDonnees/Utilisateurs', [AdminsModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/AjoutUtilisateurs', [AdminsModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/ModifUtilisateurs/{ID_ADMIN}', [AdminsModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/Utilisateurs/{ID_ADMIN}', [AdminsModuleController::class, 'index'])->middleware('auth');
Route::get('/GestionDonnees/CompteAccesUtilisateurs/{ID_ADMIN}', [AdminsModuleController::class, 'index'])->middleware('auth');


Route::get('/FormaCampAPI/Utilisateurs', [AdminsModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Utilisateurs/{ID_ADMIN}', [AdminsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Utilisateurs', [AdminsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Utilisateurs/{ID_ADMIN}', [AdminsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Utilisateurs/{ID_ADMIN}', [AdminsModuleController::class, 'Delete'])->middleware('auth');

//Route::get('/greeting', function () {
//    $user =  New User();
//    $user->email = 'somokos@somokos.com';
//    $user->password = Hash::make('somokos@somokos.com');
//    $user->DATE = date('Y-m-d H:i:s');
//    $user->UPDATE_DATE = date('Y-m-d H:i:s');
//    $user->TYPE = 'Admin';
//    $user->save();
//    $admin =  New \App\Modules\AdminsModule\Http\Models\AdminsModuleModel();
//    $admin->ID_ADMIN = $user->ID_USER;
//    $admin->save();
//});

