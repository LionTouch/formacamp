<?php

namespace App\Modules\RapportModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SuiviActivitesController extends Controller
{
    public function List(){
        return SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->where('organismes.ID_USER',Auth::id())
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->select(
                'sessions.*',
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
            ->get();
    }
}
