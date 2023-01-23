<?php

/*
|--------------------------------------------------------------------------
| DashboardModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the DashboardModule module have to go in here.
|
*/

Route::get('/Dashboard', 'DashboardModuleController@index')
    ->middleware('auth')
    ->name('dashboard');
//Route::get('/Dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('Dashboard');
