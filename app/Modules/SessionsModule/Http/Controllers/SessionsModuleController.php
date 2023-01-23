<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\AdminsModule\Http\Models\AdminsModuleModel;
use App\Modules\FormateursModule\Http\Models\FormateursModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use Auth;
use Illuminate\Support\Facades\DB;

class SessionsModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->where('organismes.ID_USER',Auth::id())
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->with('apprenants')
//            ->with('intervenants')
            ->select(
                'sessions.*',
                'clients.NOM as NOM_CLIENT',
                'clients.EMAIL as EMAIL_CLIENT',
                'lieu_formation.NOM as NOM_LIEU_FORMATION',
                'organismes.NOM as NOM_ORGANISME',
                'domaines.NOM as NOM_DOMAINE',
                'diplomes.NOM as NOM_DIPLOME',
                'action_formation.NOM as NOM_ACTION',
                DB::raw("
                 CASE
                       WHEN NOW() <= FIN THEN 0
                       WHEN NOW() > FIN THEN 1
                 END
                 as TERMINEE"),
            )
            ->get();
    }
    public function Get($id){

        return  SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('sessions_modules','sessions_modules.ID_SESSION','sessions.ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->where('organismes.ID_USER',Auth::id())
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->with('apprenants')
            ->with('intervenants')
            ->with('seances')
            ->select('sessions.*',
                'clients.NOM as NOM_CLIENT',
                'lieu_formation.NOM as NOM_LIEU_FORMATION',
                'organismes.NOM as NOM_ORGANISME',
                'domaines.NOM as NOM_DOMAINE',
                'diplomes.NOM as NOM_DIPLOME',
                'action_formation.NOM as NOM_ACTION',
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE')

            )->groupBy('sessions.ID_SESSION')
            ->findOrFail($id);

    }
    public function Save(Request $request){
        $session = New SessionsModuleModel();
        $session->ID_ORGANISME = $request->ID_ORGANISME;
        $session->NOM = $request->NOM;
        $session->ID_CLIENT = $request->ID_CLIENT;
        $session->ID_LIEU_FORMATION = $request->ID_LIEU_FORMATION;
        $session->TYPE_CLIENT = $request->TYPE_CLIENT;
        $session->TRAITANCE = $request->TRAITANCE;
        $session->ID_DOMAINE = $request->ID_DOMAINE;
        $session->ID_ACTION = $request->ID_ACTION;
        $session->ID_DIPLOME = $request->ID_DIPLOME;
        $session->TYPE = $request->TYPE;
        $session->TITRE_VISE = $request->TITRE_VISE;
        $session->DEBUT = $request->DEBUT;
        $session->FIN = $request->FIN;
        $session->DATE = date('Y-m-d H:i:s');
        $session->REF = 'FC'.strtotime("now");
        $session->save();
        return response()->json(['result'=>true,'id'=>$session->ID_SESSION]);
    }

    public function Update(Request $request,$id){
        $session = SessionsModuleModel::findOrFail($id);
        $session->ID_ORGANISME = $request->ID_ORGANISME;
        $session->NOM = $request->NOM;
        $session->ID_CLIENT = $request->ID_CLIENT;
        $session->ID_LIEU_FORMATION = $request->ID_LIEU_FORMATION;
        $session->TYPE_CLIENT = $request->TYPE_CLIENT;
        $session->TRAITANCE = $request->TRAITANCE;
        $session->ID_DOMAINE = $request->ID_DOMAINE;
        $session->ID_ACTION = $request->ID_ACTION;
        $session->TITRE_VISE = $request->TITRE_VISE;
        $session->DEBUT = $request->DEBUT;
        $session->FIN = $request->FIN;
        $session->save();
        return response()->json(['result'=>true,'id'=>$session->ID_SESSION]);
    }

    public function Delete($id){
        SessionsModuleModel::destroy($id);
        return response()->json(true);
    }

    public function ListGestionnaire(){
        $admins = AdminsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','organisme_admins.ID_ORGANISME')
            ->leftJoin('users','organisme_admins.ID_ADMIN','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('organisme_admins.ID_ADMIN as ID','organisme_admins.NOM','organisme_admins.PRENOM', DB::raw('"Admin" as TYPE'));
        return FormateursModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','formateurs.ID_ORGANISME')
            ->leftJoin('users','formateurs.ID_FORMATEUR','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('formateurs.ID_FORMATEUR as ID','formateurs.NOM','formateurs.PRENOM', DB::raw('"Formateur" as TYPE'))
            ->union($admins)
            ->orderby('TYPE','ASC')
            ->orderby('NOM','ASC')
            ->get();
    }
    public function ListIntervenants(){
        $admins = AdminsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','organisme_admins.ID_ORGANISME')
            ->leftJoin('users','organisme_admins.ID_ADMIN','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('organisme_admins.ID_ADMIN as ID','organisme_admins.NOM','organisme_admins.PRENOM', DB::raw('"Admin" as TYPE'));
        return FormateursModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','formateurs.ID_ORGANISME')
            ->leftJoin('users','formateurs.ID_FORMATEUR','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('formateurs.ID_FORMATEUR as ID','formateurs.NOM','formateurs.PRENOM', DB::raw('"Formateur" as TYPE'))
            ->union($admins)
            ->orderby('TYPE','ASC')
            ->orderby('NOM','ASC')
            ->get();
    }
    public function UpdateAction(Request $request,$id){
        $session = SessionsModuleModel::findOrFail($id);
        $session->ID_ACTION = $request->ID_ACTION;
        $session->save();
        return response()->json(true);
    }
    public function UpdateProgramme(Request $request,$id){
        $session = SessionsModuleModel::findOrFail($id);
        $session->ID_PROGRAMME = $request->ID_PROGRAMME;
        $session->save();
        return response()->json(true);
    }
    public function UpdateType(Request $request,$id){
        $session = SessionsModuleModel::findOrFail($id);
        $session->TYPE = $request->TYPE;
        $session->save();
        return response()->json(true);
    }
}
