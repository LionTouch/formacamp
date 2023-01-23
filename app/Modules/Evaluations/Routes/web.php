<?php

/*
|--------------------------------------------------------------------------
| Evaluations Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the Evaluations module have to go in here.
|
*/

Route::get('/Evaluation/{REF_APPRENANT}', 'EvaluationsController@index');
Route::get('/Evaluation/Quest/{REF_APPRENANT}', 'EvaluationsController@Get');
Route::post('/Evaluation/Quest', 'EvaluationsController@Save');
