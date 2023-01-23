<?php

/*
|--------------------------------------------------------------------------
| SessionsModule Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the SessionsModule module have to go in here.
|
*/
use App\Modules\SessionsModule\Http\Controllers\SessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\TarifPrixModulesSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\TypePrixModulesSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\ModulesModalitesSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\ModulesSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\PrixModulesSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\TypesSeancesModulesSessionsController;
use App\Modules\SessionsModule\Http\Controllers\SeancesModulesSessionsController;
use App\Modules\SessionsModule\Http\Controllers\ApprenantsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\IntervenantsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\ObjectifsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\ProfilsApprenantsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\FormationsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\SousFormationsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\ProgrammeSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\IntervenantsSeancesSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\DevisSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\ContratsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\EmargementsSessionsModuleController;
use App\Modules\SessionsModule\Http\Controllers\QuestsSessionsModulesController;
use App\Modules\SessionsModule\Http\Controllers\QuestsTypesSessionsModulesController;
use App\Modules\SessionsModule\Http\Controllers\IntervenantsEmargementsSessionsModulesController;
use App\Modules\SessionsModule\Http\Controllers\ApprenantsEmargementsSessionsModulesController;
use App\Modules\SessionsModule\Http\Controllers\ApprenantsCertificatsSessionsModulesController;
use App\Modules\SessionsModule\Http\Controllers\ApprenantsAttestationsSessionsModulesController;

Route::get('/Sessions', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/Ajout', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Modules', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Modules/{ID_MODULE}/Dates&Prix', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Apprenants', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Intervenants', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Evaluations', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Suivi', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Emargements', [SessionsModuleController::class, 'index'])->middleware('auth');
Route::get('/Sessions/{ID_SESSION}/Programme', [SessionsModuleController::class, 'index'])->middleware('auth');



Route::get('/FormaCampAPI/Sessions', [SessionsModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Sessions/{ID_SESSION}', [SessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Sessions', [SessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Sessions/{ID_SESSION}', [SessionsModuleController::class, 'Update'])->middleware('auth');
Route::put('/FormaCampAPI/Sessions/Type/{ID_SESSION}', [SessionsModuleController::class, 'UpdateType'])->middleware('auth');
Route::put('/FormaCampAPI/Sessions/Action/{ID_SESSION}', [SessionsModuleController::class, 'UpdateAction'])->middleware('auth');
Route::put('/FormaCampAPI/Sessions/Programme/{ID_SESSION}', [SessionsModuleController::class, 'UpdateProgramme'])->middleware('auth');
Route::delete('/FormaCampAPI/Sessions/{ID_SESSION}', [SessionsModuleController::class, 'Delete'])->middleware('auth');


Route::get('/FormaCampAPI/Modules', [ModulesSessionsModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Modules/Session/{ID_SESSION}', [ModulesSessionsModuleController::class, 'ListBySession'])->middleware('auth');
Route::get('/FormaCampAPI/Modules/{ID_MODULE}', [ModulesSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Modules', [ModulesSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Modules/{ID_MODULE}', [ModulesSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Modules/{ID_MODULE}', [ModulesSessionsModuleController::class, 'Delete'])->middleware('auth');


Route::get('/FormaCampAPI/ListGestionnaire', [SessionsModuleController::class, 'ListGestionnaire'])->middleware('auth');
Route::get('/FormaCampAPI/ModalitesModules', [ModulesModalitesSessionsModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/TypesSeancesModules', [TypesSeancesModulesSessionsController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/TypesPrixModules', [TypePrixModulesSessionsModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/TarifPrixModules', [TarifPrixModulesSessionsModuleController::class, 'List'])->middleware('auth');


Route::get('/FormaCampAPI/PrixModules', [PrixModulesSessionsModuleController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/PrixModules/Module/{ID_MODULE}', [PrixModulesSessionsModuleController::class, 'ListByModule'])->middleware('auth');
Route::get('/FormaCampAPI/PrixModules/{ID_PRIX}', [PrixModulesSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/PrixModules', [PrixModulesSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/PrixModules/{ID_PRIX}', [PrixModulesSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/PrixModules/{ID_PRIX}', [PrixModulesSessionsModuleController::class, 'Delete'])->middleware('auth');


Route::get('/FormaCampAPI/Seances', [SeancesModulesSessionsController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Seances/Module/{ID_MODULE}', [SeancesModulesSessionsController::class, 'ListByModule'])->middleware('auth');
Route::get('/FormaCampAPI/Seances/Session/{ID_SESSION}', [SeancesModulesSessionsController::class, 'ListBySession'])->middleware('auth');
Route::get('/FormaCampAPI/Seances/{ID_SEANCE}', [SeancesModulesSessionsController::class, 'Get'])->middleware('auth');
//Route::post('/FormaCampAPI/Seances', [SeancesModulesSessionsController::class, 'Save'])->middleware('auth');
Route::post('/FormaCampAPI/Seances', [SeancesModulesSessionsController::class, 'SaveMultiple'])->middleware('auth');
Route::put('/FormaCampAPI/Seances/{ID_SEANCE}', [SeancesModulesSessionsController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Seances/{ID_SEANCE}', [SeancesModulesSessionsController::class, 'Delete'])->middleware('auth');

Route::get('/FormaCampAPI/Apprenants',[ApprenantsSessionsModuleController::class,'List'])->middleware('auth');
Route::get('/FormaCampAPI/Apprenants/Session/{ID_SESSION}', [ApprenantsSessionsModuleController::class, 'ListBySession'])->middleware('auth');
Route::get('/FormaCampAPI/test/{ID_SESSION}', [ApprenantsSessionsModuleController::class, 'test'])->middleware('auth');
Route::get('/FormaCampAPI/Apprenants/SessionNot/{ID_SESSION}', [ApprenantsSessionsModuleController::class, 'ListNotInSession'])->middleware('auth');
Route::get('/FormaCampAPI/Apprenants/Evaluation/{ID_SESSION}', [ApprenantsSessionsModuleController::class, 'ListBySessionPassed'])->middleware('auth');
Route::get('/FormaCampAPI/Apprenants/{ID_APPRENANT}', [ApprenantsSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Apprenants', [ApprenantsSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Apprenants/{ID_APPRENANT}', [ApprenantsSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Apprenants/{ID_APPRENANT}', [ApprenantsSessionsModuleController::class, 'Delete'])->middleware('auth');


Route::get('/FormaCampAPI/Intervenants',[IntervenantsSessionsModuleController::class,'List'])->middleware('auth');
Route::get('/FormaCampAPI/Intervenants/Session/{ID_SESSION}', [IntervenantsSessionsModuleController::class, 'ListBySession'])->middleware('auth');
Route::get('/FormaCampAPI/Intervenants/SessionNot/{ID_SESSION}', [IntervenantsSessionsModuleController::class, 'ListNotInSession'])->middleware('auth');
Route::get('/FormaCampAPI/Intervenants/{ID_INTERVENANT}', [IntervenantsSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Intervenants', [IntervenantsSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Intervenants/{ID_INTERVENANT}', [IntervenantsSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Intervenants/{ID_INTERVENANT}', [IntervenantsSessionsModuleController::class, 'Delete'])->middleware('auth');



Route::get('/FormaCampAPI/Objectifs',[ObjectifsSessionsModuleController::class,'List'])->middleware('auth');
Route::get('/FormaCampAPI/Objectifs/Session/{ID_SESSION}', [ObjectifsSessionsModuleController::class, 'ListBySession'])->middleware('auth');
Route::get('/FormaCampAPI/Objectifs/{ID_OBJECTIF}', [ObjectifsSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Objectifs', [ObjectifsSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Objectifs/{ID_OBJECTIF}', [ObjectifsSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Objectifs/{ID_OBJECTIF}', [ObjectifsSessionsModuleController::class, 'Delete'])->middleware('auth');


Route::get('/FormaCampAPI/ProfilsApprenants',[ProfilsApprenantsSessionsModuleController::class,'List'])->middleware('auth');
Route::get('/FormaCampAPI/ProfilsApprenants/Session/{ID_SESSION}', [ProfilsApprenantsSessionsModuleController::class, 'ListBySession'])->middleware('auth');
Route::get('/FormaCampAPI/ProfilsApprenants/{ID_PROFIL}', [ProfilsApprenantsSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/ProfilsApprenants', [ProfilsApprenantsSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/ProfilsApprenants/{ID_PROFIL}', [ProfilsApprenantsSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/ProfilsApprenants/{ID_PROFIL}', [ProfilsApprenantsSessionsModuleController::class, 'Delete'])->middleware('auth');

Route::get('/FormaCampAPI/Formations',[FormationsSessionsModuleController::class,'List'])->middleware('auth');
Route::get('/FormaCampAPI/Formations/Session/{ID_SESSION}', [FormationsSessionsModuleController::class, 'ListBySession'])->middleware('auth');
Route::get('/FormaCampAPI/Formations/{ID_FORMATION}', [FormationsSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/Formations', [FormationsSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/Formations/{ID_FORMATION}', [FormationsSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/Formations/{ID_FORMATION}', [FormationsSessionsModuleController::class, 'Delete'])->middleware('auth');

Route::get('/FormaCampAPI/SousFormations',[SousFormationsSessionsModuleController::class,'List'])->middleware('auth');
Route::get('/FormaCampAPI/SousFormations/{ID_SUB_FORMATION}', [SousFormationsSessionsModuleController::class, 'Get'])->middleware('auth');
Route::post('/FormaCampAPI/SousFormations', [SousFormationsSessionsModuleController::class, 'Save'])->middleware('auth');
Route::put('/FormaCampAPI/SousFormations/{ID_SUB_FORMATION}', [SousFormationsSessionsModuleController::class, 'Update'])->middleware('auth');
Route::delete('/FormaCampAPI/SousFormations/{ID_SUB_FORMATION}', [SousFormationsSessionsModuleController::class, 'Delete'])->middleware('auth');

//Route::get('/FormaCampAPI/Programme',[ProgrammeSessionsModuleController::class,'List'])->middleware('auth');
//Route::get('/FormaCampAPI/Programme/Session/{ID_SESSION}',[ProgrammeSessionsModuleController::class,'GetBySession'])->middleware('auth');
//Route::get('/FormaCampAPI/Programme/{ID_PROGRAMME}', [ProgrammeSessionsModuleController::class, 'Get'])->middleware('auth');
//Route::post('/FormaCampAPI/Programme', [ProgrammeSessionsModuleController::class, 'Save'])->middleware('auth');
//Route::put('/FormaCampAPI/Programme/{ID_PROGRAMME}', [ProgrammeSessionsModuleController::class, 'Update'])->middleware('auth');
//Route::delete('/FormaCampAPI/Programme/{ID_PROGRAMME}', [ProgrammeSessionsModuleController::class, 'Delete'])->middleware('auth');

Route::post('/FormaCampAPI/SeancesIntervenants', [IntervenantsSeancesSessionsModuleController::class, 'Save'])->middleware('auth');
Route::delete('/FormaCampAPI/SeancesIntervenants/{ID_INTERVENANT}/{ID_SEANCE}', [IntervenantsSeancesSessionsModuleController::class, 'Delete'])->middleware('auth');
Route::post('/FormaCampAPI/SeancesIntervenantsMultiple', [IntervenantsSeancesSessionsModuleController::class, 'SaveMultiple'])->middleware('auth');
Route::delete('/FormaCampAPI/SeancesIntervenants/{DATA}', [IntervenantsSeancesSessionsModuleController::class, 'DeleteMultiple'])->middleware('auth');


Route::get('/Devis/{ID_SESSION}', [DevisSessionsModuleController::class, 'download'])->middleware('auth');
Route::get('/Contrat/{ID_SESSION}', [ContratsSessionsModuleController::class, 'download'])->middleware('auth');
Route::post('/Devis', [DevisSessionsModuleController::class, 'Send'])->middleware('auth');
Route::post('/Contrat', [ContratsSessionsModuleController::class, 'Send'])->middleware('auth');
Route::get('/test', [DevisSessionsModuleController::class, 'test'])->middleware('auth');
Route::get('/Emargement/{ID_SESSION}/{ID_APPRENANT}', [EmargementsSessionsModuleController::class, 'download'])->middleware('auth');
Route::post('/Emargement', [EmargementsSessionsModuleController::class, 'Send'])->middleware('auth');
Route::get('/Certificat/{ID_SESSION}/{ID_APPRENANT}', [ApprenantsCertificatsSessionsModulesController::class, 'download'])->middleware('auth');
Route::post('/Certificat', [ApprenantsCertificatsSessionsModulesController::class, 'Send'])->middleware('auth');
Route::get('/Attestation/{ID_SESSION}/{ID_APPRENANT}', [ApprenantsAttestationsSessionsModulesController::class, 'download'])->middleware('auth');
Route::post('/Attestation', [ApprenantsAttestationsSessionsModulesController::class, 'Send'])->middleware('auth');

Route::get('/FormaCampAPI/QuestTypes', [QuestsTypesSessionsModulesController::class, 'List'])->middleware('auth');

//Route::delete('/FormaCampAPI/Quests/{ID_QUEST}', [QuestsSessionsModulesController::class, 'Delete'])->middleware('auth');
Route::get('/FormaCampAPI/Quest', [QuestsSessionsModulesController::class, 'List'])->middleware('auth');
Route::get('/FormaCampAPI/Quest/{ID_SESSION}', [QuestsSessionsModulesController::class, 'ListBySession'])->middleware('auth');
Route::delete('/FormaCampAPI/Quest/{ID_SESSION}', [QuestsSessionsModulesController::class, 'DeleteAll'])->middleware('auth');
Route::post('/FormaCampAPI/Quest', [QuestsSessionsModulesController::class, 'SaveAll'])->middleware('auth');
Route::post('/FormaCampAPI/SendEval', [QuestsSessionsModulesController::class, 'SendEval'])->middleware('auth');

Route::post('/FormaCampAPI/EmargementIntervenants', [IntervenantsEmargementsSessionsModulesController::class, 'Save'])->middleware('auth');
Route::delete('/FormaCampAPI/EmargementIntervenants/{ID_SEANCE}/{ID_INTERVENANT}', [IntervenantsEmargementsSessionsModulesController::class, 'Delete'])->middleware('auth');

Route::post('/FormaCampAPI/EmargementApprenants', [ApprenantsEmargementsSessionsModulesController::class, 'Save'])->middleware('auth');
Route::delete('/FormaCampAPI/EmargementApprenants/{ID_SEANCE}/{ID_APPRENANT}', [ApprenantsEmargementsSessionsModulesController::class, 'Delete'])->middleware('auth');
