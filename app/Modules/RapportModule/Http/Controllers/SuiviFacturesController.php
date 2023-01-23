<?php

namespace App\Modules\RapportModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ModulesSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use DB;
class SuiviFacturesController extends Controller
{
    public function List(){

        $prix_ht = ModulesSessionsModuleModel::leftjoin('sessions_modules_prix','sessions_modules.ID_MODULE','sessions_modules_prix.ID_MODULE')
            ->leftjoin('sessions_type_prix_modules','sessions_type_prix_modules.ID_TYPE_PRIX','sessions_modules_prix.ID_TYPE_PRIX')
            ->leftjoin('sessions_apprenants','sessions_apprenants.ID_SESSION','sessions_modules.ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules_prix.ID_MODULE')
            ->select(
                'sessions_modules.ID_SESSION',
                'ID_PRIX',
                DB::raw('
                (CASE
                       WHEN sessions_modules_prix.ID_TARIF = 1 THEN ROUND(PRIX,2)
                       WHEN sessions_modules_prix.ID_TARIF = 2 THEN ROUND(PRIX * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 3 THEN ROUND(PRIX * COUNT(DISTINCT sessions_modules_seances.DATE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 4 THEN ROUND(PRIX * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)),2)
                       WHEN sessions_modules_prix.ID_TARIF = 5 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT),2)
                       WHEN sessions_modules_prix.ID_TARIF = 6 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 7 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.DATE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 8 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)),2)
                 END)
                 as PRIX_HT')
            )->whereNotNull('ID_PRIX')
            ->groupBy('ID_PRIX','ID_SESSION');
//        dd($prix_ht->orderBy('ID_SESSION')->get());
        return SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('users','users.ID_USER','organismes.ID_USER')
            ->leftjoin('admins','admins.ID_ADMIN','users.ID_USER')
            ->leftjoin('sessions_modules','sessions_modules.ID_SESSION','sessions.ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->where('organismes.ID_USER',Auth::id())
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->leftjoinSub($prix_ht, 'prix_ht', function ($join) {
                $join->on('sessions.ID_SESSION', '=', 'prix_ht.ID_SESSION');
            })
            ->select(
                'sessions.ID_SESSION',
                'sessions.DATE',
                'sessions.REF',
                'sessions.NOM',
                'sessions.DEBUT',
                'sessions.FIN',
                'sessions.TITRE_VISE',
                'admins.NOM as NOM_ADMIN',
                'admins.PRENOM as PRENOM_ADMIN',
                'users.email as EMAIL_ORGANISME',
                DB::raw("
                CASE
                    WHEN SUM(prix_ht.PRIX_HT)/COUNT(DISTINCT prix_ht.ID_PRIX) IS NOT NULL THEN ROUND(SUM(prix_ht.PRIX_HT)/COUNT(DISTINCT prix_ht.ID_PRIX),2)
                    ELSE 0
                    END
                    as PRIX_HTT,
                 CASE
                       WHEN ISNULL(clients.NOM) = 1 THEN 'Aucun Client'
                       WHEN ISNULL(clients.NOM) = 0 THEN clients.NOM

                 END
                 as NOM_CLIENT"),
                'clients.ADRESSE as ADRESSE_CLIENT',
                'lieu_formation.NOM as NOM_LIEU_FORMATION',
                'organismes.NUM_DEC as NUM_DEC_ORGANISME',
                'organismes.TELEPHONE as TELEPHONE_ORGANISME',
                'organismes.REGION_ACQUISITON as REGION_ACQUISITON_ORGANISME',
                'organismes.NOM as NOM_ORGANISME',
                'organismes.SIRET as SIRET_ORGANISME',
                'organismes.NUM_TVA as NUM_TVA_ORGANISME',
                'domaines.NOM as NOM_DOMAINE',
                'diplomes.NOM as NOM_DIPLOME',
                'action_formation.NOM as NOM_ACTION',
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('COUNT(DISTINCT sessions_modules_seances.DATE) as DUREE_TOTALE_J'),
                DB::raw("
                 CASE
                       WHEN NOW() >= DEBUT AND NOW() < FIN THEN 'Planification en cours'
                       WHEN NOW() < DEBUT THEN 'Planifiées'
                       WHEN NOW() >= FIN THEN 'Terminées'
                 END
                 as TYPE")
            )->groupBy('sessions.ID_SESSION')->get();

    }
}
