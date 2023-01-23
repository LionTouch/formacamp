<?php

namespace App\Modules\RapportModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ApprenantsEmargementsSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\ApprenantsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SeancesModulesSessionsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
class SuiviPedagogiquesController extends Controller
{
    public function List(){
        $duree_session = SeancesModulesSessionsModel::leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->select(
                'DUREE',
                DB::raw('
                CASE WHEN SUM(DUREE) IS NOT NULL THEN  SUM(DUREE) ELSE 0 END
                as DUREE_SESSION'),
                'ID_SESSION'
            )->groupBy('ID_SESSION');

        $apprenants =  ApprenantsEmargementsSessionsModulesModel::leftjoin('sessions_modules_seances','sessions_modules_seances.ID_SEANCE','sessions_apprenants_emargements.ID_SEANCE')
            ->leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->leftjoinSub($duree_session, 'duree_session', function ($join) {
                $join->on('sessions_modules.ID_SESSION', '=', 'duree_session.ID_SESSION');
            })
            ->select(
                'sessions_apprenants_emargements.ID_APPRENANT',
                'sessions_modules.ID_SESSION',
                'sessions_modules_seances.DUREE',
                'duree_session.DUREE_SESSION',
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_REALISE'),
                DB::raw('ROUND(SUM(sessions_modules_seances.DUREE)*100/duree_session.DUREE_SESSION,2) as PERCENT'),
            )->groupBy('sessions_apprenants_emargements.ID_APPRENANT','sessions_modules.ID_SESSION');

        return ApprenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_apprenants.ID_SESSION')
            ->leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoinSub($apprenants, 'apprenants', function ($join) {
                $join->on('sessions_apprenants.ID_APPRENANT', '=', 'apprenants.ID_APPRENANT')
                     ->on('apprenants.ID_SESSION', '=', 'sessions_apprenants.ID_SESSION');
            })
            ->select(
                'sessions_apprenants.ID_APPRENANT',
                'sessions_apprenants.ID_SESSION',
                'sessions_apprenants.REF',
                'stagiaires.PHOTO',
                'stagiaires.NOM',
                'stagiaires.PRENOM',
                'stagiaires.EMAIL',
                'stagiaires.TELEPHONE',
                'organismes.NOM as NOM_ORGANISME',
                'sessions.NOM as NOM_SESSION',
                'clients.NOM as NOM_CLIENT',
                DB::raw("
                 CASE
                       WHEN NOW() >= sessions.DEBUT AND NOW() < FIN THEN 'Formation en cours'
                       WHEN NOW() < sessions.DEBUT THEN 'Formation planifiées'
                       WHEN NOW() >= sessions.FIN THEN 'Formation terminées'
                 END
                 as TYPE,
                 CASE WHEN apprenants.DUREE_SESSION IS NOT NULL THEN apprenants.DUREE_SESSION ELSE 0 END
                 as DUREE_SESSION,
                 CASE WHEN apprenants.DUREE_REALISE IS NOT NULL THEN apprenants.DUREE_REALISE ELSE 0 END
                 as DUREE_REALISE,
                 CASE WHEN apprenants.PERCENT IS NOT NULL THEN apprenants.PERCENT ELSE 0 END
                 as PERCENT
                 ")
            )
            ->orderBy('sessions.DEBUT')
            ->orderBy('stagiaires.NOM')
            ->get();
    }
}
