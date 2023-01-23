<?php

/*
|--------------------------------------------------------------------------
| AgendaModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the AgendaModule module have to go in here.
|
*/
use App\Modules\AgendaModule\Http\Controllers\AgendaModuleController;

Route::get('/Agenda', [AgendaModuleController::class, 'index'])->middleware('auth');
Route::get('/FormaCampAPI/Agenda', [AgendaModuleController::class, 'List'])->middleware('auth');
