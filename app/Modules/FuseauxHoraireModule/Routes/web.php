<?php

/*
|--------------------------------------------------------------------------
| FuseauxHoraireModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the FuseauxHoraireModule module have to go in here.
|
*/
use App\Modules\FuseauxHoraireModule\Http\Controllers\FuseauxHoraireModuleController;

Route::get('/FormaCampAPI/FuseauxHoraire', [FuseauxHoraireModuleController::class, 'List'])->middleware('auth');
