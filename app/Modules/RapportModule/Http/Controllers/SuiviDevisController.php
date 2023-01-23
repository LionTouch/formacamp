<?php

namespace App\Modules\RapportModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\IntervenantsEmargementsSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use DB;
class SuiviDevisController extends Controller
{
    public function List(){
        $seances_p = IntervenantsEmargementsSessionsModulesModel::join('sessions_modules_seances','sessions_modules_seances.ID_SEANCE','sessions_intervenants_emargements.ID_SEANCE')
            ->join('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->distinct('ID_SEANCE')
            ->select('sessions_intervenants_emargements.ID_SEANCE','sessions_modules_seances.ID_MODULE','ID_SESSION','DUREE');
        return SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->where('organismes.ID_USER',Auth::id())
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->leftjoinSub($seances_p, 'seances_p', function ($join) {
                $join->on('sessions.ID_SESSION', '=', 'seances_p.ID_SESSION');
            })
            ->groupby('ID_SESSION')
            ->select(
                'sessions.*',
                DB::raw('SUM( seances_p.DUREE) as DUREE_REALISE'),
                'clients.EMAIL as EMAIL_CLIENT',
                DB::raw("
                 CASE
                       WHEN ISNULL(clients.NOM) = 1 THEN 'Aucun Client'
                       WHEN ISNULL(clients.NOM) = 0 THEN clients.NOM
                 END
                 as NOM_CLIENT"),
                'lieu_formation.NOM as NOM_LIEU_FORMATION',
                'organismes.NOM as NOM_ORGANISME',
                'domaines.NOM as NOM_DOMAINE',
                'diplomes.NOM as NOM_DIPLOME',
                'action_formation.NOM as NOM_ACTION',
                DB::raw("
                 CASE
                       WHEN NOW() >= DEBUT AND NOW() < FIN THEN 'Planification en cours'
                       WHEN NOW() < DEBUT THEN 'Planifiées'
                       WHEN NOW() >= FIN THEN 'Terminées'
                 END
                 as TYPE")
            )
            ->withSum('seances','DUREE')
            ->withCount('apprenants')
            ->get();
    }
}
