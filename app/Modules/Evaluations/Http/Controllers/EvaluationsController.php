<?php

namespace App\Modules\Evaluations\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ApprenantsQuestsReponsesSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\ApprenantsQuestsSubsReponsesSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\ApprenantsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\QuestsApprenantsSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\QuestsSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\Evaluations\Http\Models\EvaluationsModel;
use DB;
class EvaluationsController extends Controller
{
    public function index()
    {
        return view('evaluation');
    }

    public function Get($ref){
        $apprenant = ApprenantsSessionsModuleModel::where('REF',$ref)
            ->leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->first();
        $session = SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('sessions_modules','sessions_modules.ID_SESSION','sessions.ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->select('sessions.*',
                'clients.NOM as NOM_CLIENT',
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
                 as TYPE"),
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE')

            )->groupBy('sessions.ID_SESSION')
            ->findOrFail($apprenant->ID_SESSION);
        if($apprenant){
            if($apprenant->PASSED){
                $quests = QuestsSessionsModulesModel::leftjoin('sessions','sessions.ID_SESSION','sessions_quest.ID_SESSION')
                    ->leftjoin('sessions_quest_types','sessions_quest_types.ID_TYPE','sessions_quest.ID_TYPE')
                    ->leftjoin('sessions_apprenants_quest_reponses','sessions_apprenants_quest_reponses.ID_QUEST','sessions_quest.ID_QUEST')
                    ->where('sessions_apprenants_quest_reponses.ID_APPRENANT',$apprenant->ID_APPRENANT)
                    ->where('sessions.ID_SESSION',$apprenant->ID_SESSION)
                    ->select(
                        'sessions_quest.*',
                        'sessions_apprenants_quest_reponses.REPONSE as reponse',
                        'sessions.NOM as NOM_SESSION',
                        DB::raw('true as "PASSED"')
                    )
                    ->with('sub_quests',function ($q) use ($apprenant){
                        $q->where('ID_APPRENANT',$apprenant->ID_APPRENANT);
                    })
                    ->with('reponses')
                    ->orderBy('ID_QUEST')
                    ->get();
                return response()->json(['result'=>true,'data'=>$quests,'session'=>$session,'apprenant'=>$apprenant]);
            }else{
                $quests = QuestsSessionsModulesModel::leftjoin('sessions','sessions.ID_SESSION','sessions_quest.ID_SESSION')
                    ->leftjoin('sessions_quest_types','sessions_quest_types.ID_TYPE','sessions_quest.ID_TYPE')
                    ->where('sessions.ID_SESSION',$apprenant->ID_SESSION)
                    ->select(
                        'sessions_quest.*',
                        'sessions.NOM as NOM_SESSION',
                    )
                    ->with('sub_quests')
                    ->with('reponses')
                    ->orderBy('ID_QUEST')
                    ->get();
                return response()->json(['data'=>$quests,'session'=>$session,'apprenant'=>$apprenant]);
            }

        }else{
            return response()->json(false);
        }

    }

    public function Save(Request $request){
        $quests = json_decode($request->quests);
        $apprenant = ApprenantsSessionsModuleModel::where('REF',$request->REF)->first();

        foreach ($quests as $q){
            if(isset($q->reponse)){
                $reponse = new ApprenantsQuestsReponsesSessionsModulesModel();
                $reponse->ID_APPRENANT = $apprenant->ID_APPRENANT;
                $reponse->ID_QUEST = $q->ID_QUEST;
                $reponse->REPONSE = gettype($q->reponse)=='array'? json_encode($q->reponse):$q->reponse;
                $reponse->save();
            }else{
                $reponse = new ApprenantsQuestsReponsesSessionsModulesModel();
                $reponse->ID_APPRENANT = $apprenant->ID_APPRENANT;
                $reponse->ID_QUEST = $q->ID_QUEST;
                $reponse->REPONSE = null;
                $reponse->save();
                foreach ($q->sub_quests as $sub_quest){
                    $reponse2 = new ApprenantsQuestsSubsReponsesSessionsModulesModel();
                    $reponse2->ID_APPRENANT = $apprenant->ID_APPRENANT;
                    $reponse2->ID_SUB_QUEST = $sub_quest->ID_SUB_QUEST;
                    $reponse2->REPONSE = $sub_quest->reponse;
                    $reponse2->save();
                }

            }
        }
        ApprenantsSessionsModuleModel::where('REF',$request->REF)->update(['PASSED'=>true]);
        return response()->json(true);

    }
}
