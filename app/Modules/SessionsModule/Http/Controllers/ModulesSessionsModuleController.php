<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ModulesSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ModulesSessionsModuleController extends Controller
{
    public function List(){
        return ModulesSessionsModuleModel::leftjoin('sessions','sessions.ID_SESSION','sessions_modules.ID_SESSION')
            ->leftjoin('sessions_modules_modalites','sessions_modules.ID_MODALITE','sessions_modules_modalites.ID_MODALITE')
            ->select('sessions_modules.*','sessions.NOM as NOM_SESSION','sessions_modules_modalites.NOM as NOM_MODALITE')
            ->get();
    }
    public function ListBySession($id){

        return ModulesSessionsModuleModel::leftjoin('sessions','sessions.ID_SESSION','sessions_modules.ID_SESSION')
            ->leftjoin('sessions_modules_modalites','sessions_modules.ID_MODALITE','sessions_modules_modalites.ID_MODALITE')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->where('sessions_modules.ID_SESSION',$id)
            ->select(
                'sessions_modules.*',
                'sessions.NOM as NOM_SESSION',
                'sessions.DEBUT',
                'sessions.FIN',
                'sessions_modules_modalites.NOM as NOM_MODALITE',
                DB::raw('MIN(sessions_modules_seances.DATE) as START'),
                DB::raw('MAX(sessions_modules_seances.DATE) as END'),
            )
            ->orderBy('START')
            ->groupBy('sessions_modules.ID_MODULE')
            ->with('prix')
            ->with('seances')
            ->get();
    }
    public function Get($id){
        return ModulesSessionsModuleModel::leftjoin('sessions','sessions.ID_SESSION','sessions_modules.ID_SESSION')
            ->leftjoin('sessions_modules_modalites','sessions_modules.ID_MODALITE','sessions_modules_modalites.ID_MODALITE')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->select(
                'sessions_modules.*',
                'sessions.NOM as NOM_SESSION',
                'sessions.DEBUT',
                'sessions.FIN',
                'sessions_modules_modalites.NOM as NOM_MODALITE',
                DB::raw('MIN(sessions_modules_seances.DATE) as START'),
                DB::raw('MAX(sessions_modules_seances.DATE) as END'),
            )
            ->orderBy('START')
            ->groupBy('sessions_modules.ID_MODULE')
            ->with('prix')
            ->with('seances')
            ->findOrFail($id);
    }
    public function Save(Request $request){
        $session = New ModulesSessionsModuleModel();
        $session->NOM = $request->NOM;
        $session->ID_SESSION = $request->ID_SESSION;
        $session->ID_MODALITE = $request->ID_MODALITE;
        $session->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $session = ModulesSessionsModuleModel::findOrFail($id);
        $session->NOM = $request->NOM;
        $session->ID_SESSION = $request->ID_SESSION;
        $session->ID_MODALITE = $request->ID_MODALITE;
        $session->save();
        return response()->json(true);
    }

    public function Delete($id){
        ModulesSessionsModuleModel::destroy($id);
        return response()->json(true);
    }

}
