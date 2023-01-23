<?php

namespace App\Modules\AgendaModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\IntervenantsSeancesSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SeancesModulesSessionsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use DB;

class AgendaModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
//        return SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
//            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
//            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
//            ->where('organismes.ID_USER',Auth::id())
//            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
//            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
//            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
//            ->with('apprenants')
//            ->with('intervenants')
//            ->with('modules')
//            ->select(
//                'sessions.*',
//                DB::raw('CONCAT("Formation: ",CAST(sessions.NOM AS CHAR CHARACTER SET utf8)," Du ", DATE_FORMAT(DEBUT,"%W le %e %M, %Y"), " au ", DATE_FORMAT(FIN,"%W le %e %M, %Y") ) as title'),
//                DB::raw('CONCAT("Client: ",CAST(clients.NOM AS CHAR CHARACTER SET utf8)," Lieu:",CAST(lieu_formation.NOM AS CHAR CHARACTER SET utf8)) as description'),
//                'sessions.ID_SESSION as id',
//                'sessions.DEBUT as start',
//                'sessions.FIN as end',
//                'clients.NOM as NOM_CLIENT',
//                'lieu_formation.NOM as NOM_LIEU_FORMATION',
//                'organismes.NOM as NOM_ORGANISME',
//                'domaines.NOM as NOM_DOMAINE',
//                'diplomes.NOM as NOM_DIPLOME',
//                'action_formation.NOM as NOM_ACTION',
//                DB::raw("
//                 CASE
//                       WHEN NOW() >= DEBUT AND NOW() < FIN THEN 'Planification en cours'
//                       WHEN NOW() < DEBUT THEN 'Planifiées'
//                       WHEN NOW() > FIN THEN 'Terminées'
//                 END
//                 as TYPE,
//                  CASE
//                       WHEN NOW() >= DEBUT AND NOW() < FIN THEN '#27b345'
//                       WHEN NOW() < DEBUT THEN '#ffd369'
//                       WHEN NOW() >= FIN THEN '#6ce6f4'
//                 END
//                 as color
//
//                 ")
//            )
//            ->get();
//
        return SeancesModulesSessionsModel::leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->leftjoin('sessions_modules_types_seances','sessions_modules_types_seances.ID_TYPE_SEANCE','sessions_modules_seances.ID_TYPE_SEANCE')
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_modules.ID_SESSION')
            ->leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('salles','salles.ID_SALLE','sessions_modules_seances.ID_SALLE')
            ->select(
                'ID_SEANCE',
                'ID_SEANCE as id',
                'salles.NOM as location',
                DB::raw("
                 CASE
                       WHEN sessions.TYPE = 0 THEN '#5e3981'
                       WHEN sessions.TYPE = 1 THEN '#fbc647'
                       WHEN sessions.TYPE = 2 AND NOW() <= sessions.FIN THEN '#3dbb58'
                       WHEN sessions.TYPE = 2 AND NOW() > sessions.FIN THEN '#f35448'
                 END
                 as bgColor,
                 CASE
                       WHEN sessions.TYPE = 0 THEN '#5e3981'
                       WHEN sessions.TYPE = 1 THEN '#fbc647'
                       WHEN sessions.TYPE = 2 AND NOW() <= sessions.FIN THEN '#3dbb58'
                       WHEN sessions.TYPE = 2 AND NOW() > sessions.FIN THEN '#f35448'
                 END
                 as dragBgColor,
                  CASE
                       WHEN sessions.TYPE = 0 THEN '#5e3981'
                       WHEN sessions.TYPE = 1 THEN '#fbc647'
                       WHEN sessions.TYPE = 2 AND NOW() <= sessions.FIN THEN '#3dbb58'
                       WHEN sessions.TYPE = 2 AND NOW() > sessions.FIN THEN '#f35448'
                  END
                 as borderColor,
                 CASE
                       WHEN sessions.TYPE = 0 THEN '1'
                       WHEN sessions.TYPE = 1 THEN '2'
                       WHEN sessions.TYPE = 2 AND NOW() <= sessions.FIN THEN '3'
                       WHEN sessions.TYPE = 2 AND NOW() > sessions.FIN THEN '4'
                  END
                 as calendarId
                 "),
//                DB::raw('"name" as name'),
//                DB::raw('"0" as calendarId'),
                DB::raw('"time" as category'),
                DB::raw('"#fff" as color'),
                DB::raw('sessions_modules_types_seances.NOM as recurrenceRule'),
                DB::raw('organismes.NOM as state'),
                DB::raw('CONCAT(sessions_modules_seances.DATE,"T",sessions_modules_seances.HD,".000Z") as start'),
                DB::raw('CONCAT(sessions_modules_seances.DATE,"T",sessions_modules_seances.HF,".000Z") as end'),
                DB::raw('CONCAT("Formation: ",CAST(sessions.NOM AS CHAR CHARACTER SET utf8)," De ", DATE_FORMAT(sessions_modules_seances.HD,"%H:%i"), " à ", DATE_FORMAT(sessions_modules_seances.HF,"%H:%i") ) as title'),
                DB::raw('CONCAT("<div class=\"tui-full-calendar-section-button\"><a href=\"Sessions/",sessions.ID_SESSION,"/Modules\" class=\"edit-btn\"><span class=\"tui-full-calendar-icon tui-full-calendar-ic-edit\"></span><span class=\"tui-full-calendar-content\">Modifier</span></a></div>") as body')
            )->with('attendees')
            ->get();
    }
}
