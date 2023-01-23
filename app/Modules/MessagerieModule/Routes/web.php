<?php

/*
|--------------------------------------------------------------------------
| MessagerieModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the MessagerieModule module have to go in here.
|
*/
use App\Modules\MessagerieModule\Http\Controllers\MessagerieModuleController;
Route::get('/Messagerie', 'MessagerieModuleController@index');
Route::get('/Messagerie/NouveauMessage', 'MessagerieModuleController@index');
Route::post('/FormaCampAPI/Messagerie', 'MessagerieModuleController@index');

Route::post('/FormaCampAPI/Messagerie', [MessagerieModuleController::class, 'Send'])->middleware('auth');

Route::get('/FormaCampAPI/Messagerie/Inbox', [MessagerieModuleController::class, 'List'])->middleware('auth');

Route::get('/FormaCampAPI/Messagerie/Sent', [MessagerieModuleController::class, 'ListSent'])->middleware('auth');

Route::get('/FormaCampAPI/Messagerie/Corbeille', [MessagerieModuleController::class, 'ListCorbeille'])->middleware('auth');
Route::get('/FormaCampAPI/Messagerie/Test', [MessagerieModuleController::class, 'test'])->middleware('auth');


Route::get('/FormaCampAPI/Messagerie/Signature', [MessagerieModuleController::class, 'GetSignature'])->middleware('auth');
Route::post('/FormaCampAPI/Messagerie/Signature', [MessagerieModuleController::class, 'SaveSignature'])->middleware('auth');



Route::get('/FormaCampAPI/Messagerie/{id}/{box}', [MessagerieModuleController::class, 'Get'])->middleware('auth');
