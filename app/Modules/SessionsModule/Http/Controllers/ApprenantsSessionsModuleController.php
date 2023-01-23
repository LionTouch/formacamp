<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ApprenantsEmargementsSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\ApprenantsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SeancesModulesSessionsModel;
use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use App\Modules\StagiairesModule\Http\Models\StagiairesModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use MongoDB\Driver\Session;

class ApprenantsSessionsModuleController extends Controller
{
    public function List(){
        return ApprenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->where('sessions_apprenants.ID_SESSION',Auth::id())
            ->get();
    }
    public function ListBySession($id){
        $duree_session = SeancesModulesSessionsModel::leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->where('sessions_modules.ID_SESSION',$id)
            ->select('DUREE')
            ->get()->sum('DUREE');
        $apprenants =  ApprenantsEmargementsSessionsModulesModel::leftjoin('sessions_modules_seances','sessions_modules_seances.ID_SEANCE','sessions_apprenants_emargements.ID_SEANCE')
            ->leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->where('sessions_modules.ID_SESSION',$id)
            ->select(
                'sessions_apprenants_emargements.ID_APPRENANT',
                'sessions_modules.ID_SESSION',
                'sessions_modules_seances.DUREE',
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('ROUND(SUM(sessions_modules_seances.DUREE)*100/'.($duree_session).',2) as PERCENT'),
            )->groupBy('ID_APPRENANT');
        return ApprenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_apprenants.ID_SESSION')
            ->leftjoinSub($apprenants, 'apprenants', function ($join) {
                $join->on('sessions_apprenants.ID_APPRENANT', '=', 'apprenants.ID_APPRENANT');
            })
            ->where('sessions_apprenants.ID_SESSION',$id)
            ->select(
                'sessions_apprenants.ID_APPRENANT',
                'sessions_apprenants.ID_SESSION',
                'sessions_apprenants.REF',
                'stagiaires.PHOTO',
                'stagiaires.NOM',
                'stagiaires.PRENOM',
                'stagiaires.EMAIL',
                'stagiaires.TELEPHONE',
                'sessions.NOM as NOM_SESSION',
                DB::raw('true as "Add"'),
                'apprenants.DUREE_TOTALE',
                'apprenants.PERCENT'
            )
            ->get();
    }
    public function ListBySessionPassed($id){
        return ApprenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->where('sessions_apprenants.ID_SESSION',$id)
            ->where('sessions_apprenants.PASSED',1)
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_apprenants.ID_SESSION')
            ->select(
                'stagiaires.ID_STAGIAIRE as ID_APPRENANT',
                'stagiaires.PHOTO',
                'stagiaires.NOM',
                'stagiaires.PRENOM',
                'stagiaires.EMAIL',
                'stagiaires.TELEPHONE',
                'sessions.NOM as NOM_SESSION',
                'sessions_apprenants.REF',
                DB::raw('true as "Add"')
            )
            ->get();
    }
    public function ListNotInSession($id){
        $inter =$this->ListBySession($id)->pluck('ID_APPRENANT')->all();
        $id_client = SessionsModuleModel::find($id)->ID_CLIENT;
        return StagiairesModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','stagiaires.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->where('stagiaires.ID_CLIENT',$id_client)
            ->whereNotIn('stagiaires.ID_STAGIAIRE',$inter)
            ->select(
                'stagiaires.ID_STAGIAIRE as ID_APPRENANT',
                'stagiaires.PHOTO',
                'stagiaires.NOM',
                'stagiaires.PRENOM',
                'stagiaires.EMAIL',
                'stagiaires.TELEPHONE',
                DB::raw('false as "Add"')
            )
            ->get();


    }
    public function Get($id){
        return ApprenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->where('ID_APPRENANT',$id)
            ->first();
    }
    public function Save(Request $request){
        $apprenant = New ApprenantsSessionsModuleModel();
        $apprenant->ID_APPRENANT = $request->ID_APPRENANT;
        $apprenant->ID_SESSION = $request->ID_SESSION;
        $apprenant->REF = str_replace("/","",Hash::make(date("Y-m-d H:i:s.sss").$request->ID_SESSION.$request->ID_APPRENANT)).Str::random(100);
        $apprenant->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $apprenant = ApprenantsSessionsModuleModel::where('ID_APPRENANT',$id)->first();
        $apprenant->ID_APPRENANT = $request->ID_APPRENANT;
        $apprenant->ID_SESSION = $request->ID_SESSION;
        $apprenant->save();
        return response()->json(true);
    }

    public function Delete($id){
        ApprenantsSessionsModuleModel::where('ID_APPRENANT',$id)->delete();
        return response()->json(true);
    }
    public function test($id){
        $duree_session = SeancesModulesSessionsModel::leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->where('sessions_modules.ID_SESSION',$id)
            ->select('DUREE')
            ->get()->sum('DUREE');
        $apprenants =  ApprenantsEmargementsSessionsModulesModel::leftjoin('sessions_modules_seances','sessions_modules_seances.ID_SEANCE','sessions_apprenants_emargements.ID_SEANCE')
            ->leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->where('sessions_modules.ID_SESSION',$id)
            ->select(
                'sessions_apprenants_emargements.ID_APPRENANT',
                'sessions_modules.ID_SESSION',
                'sessions_modules_seances.DUREE',
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('ROUND(SUM(sessions_modules_seances.DUREE)*100/'.($duree_session).',2) as PERCENT'),
            )->groupBy('ID_APPRENANT');
        return ApprenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_apprenants.ID_SESSION')
            ->leftjoinSub($apprenants, 'apprenants', function ($join) {
                $join->on('sessions_apprenants.ID_APPRENANT', '=', 'apprenants.ID_APPRENANT');
            })
            ->where('sessions_apprenants.ID_SESSION',$id)
            ->select(
                'sessions_apprenants.ID_APPRENANT',
                'sessions_apprenants.ID_SESSION',
                'sessions_apprenants.REF',
                'stagiaires.PHOTO',
                'stagiaires.NOM',
                'stagiaires.PRENOM',
                'stagiaires.EMAIL',
                'stagiaires.TELEPHONE',
                'sessions.NOM as NOM_SESSION',
                DB::raw('true as "Add"'),
                'apprenants.DUREE_TOTALE',
                'apprenants.PERCENT',

            )
            ->get();
    }
}
