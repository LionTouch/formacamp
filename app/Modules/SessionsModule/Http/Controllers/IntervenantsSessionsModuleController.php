<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\AdminsModule\Http\Models\AdminsModuleModel;
use App\Modules\FormateursModule\Http\Models\FormateursModuleModel;
use App\Modules\SessionsModule\Http\Models\IntervenantsSeancesSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\IntervenantsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SeancesModulesSessionsModel;
use App\Modules\SessionsModule\Http\Models\TypesSeancesModulesSessionsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class IntervenantsSessionsModuleController extends Controller
{
    public function List(){
        return IntervenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_intervenants.ID_INTERVENANT')
            ->where('sessions_intervenants.ID_SESSION',Auth::id())
            ->get();
    }
    public function ListBySession($id){
//         return IntervenantsSessionsModuleModel::where('sessions_intervenants.ID_SESSION',$id)->with('seances')->get();
        $seances = SeancesModulesSessionsModel::join('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')->where('ID_SESSION',$id)->count();
         $admins = IntervenantsSessionsModuleModel::join('organisme_admins','organisme_admins.ID_ADMIN','sessions_intervenants.ID_INTERVENANT')
             ->where('sessions_intervenants.ID_SESSION',$id)
             ->leftjoin('sessions','sessions.ID_SESSION','sessions_intervenants.ID_SESSION')
             ->leftjoin('users','users.ID_USER','organisme_admins.ID_ADMIN')
             ->select(
                'organisme_admins.PHOTO',
                'organisme_admins.NOM',
                'organisme_admins.PRENOM',
                'organisme_admins.TELEPHONE',
                'users.email',
                'sessions.NOM as NOM_SESSION',
                 'sessions.DEBUT as MIN',
                 'sessions.FIN as MAX',
                 'sessions.DEBUT',
                 'sessions.FIN',
                'sessions_intervenants.*',
                 DB::raw('"Admin" as TYPE'),
                DB::raw('true as "Add"'),
                DB::raw($seances.' as "total_seances"')
            );

        $intervenants = IntervenantsSessionsModuleModel::join('formateurs','formateurs.ID_FORMATEUR','sessions_intervenants.ID_INTERVENANT')
            ->where('sessions_intervenants.ID_SESSION',$id)
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_intervenants.ID_SESSION')
            ->leftjoin('users','users.ID_USER','formateurs.ID_FORMATEUR')
            ->select(
                'formateurs.PHOTO',
                'formateurs.NOM',
                'formateurs.PRENOM',
                'formateurs.TELEPHONE',
                'users.email',
                'sessions.NOM as NOM_SESSION',
                'sessions.DEBUT as MIN',
                'sessions.FIN as MAX',
                'sessions.DEBUT',
                'sessions.FIN',
                'sessions_intervenants.*',
                DB::raw('"Formateur" as TYPE'),
                DB::raw('true as "Add"'),
                DB::raw($seances.' as "total_seances"')
            )
            ->union($admins)
            ->orderby('TYPE','ASC')
            ->orderby('NOM','ASC')
            ->with('modules.seances_intervenants')
            ->get()->toArray();
        $types_seances = TypesSeancesModulesSessionsModel::get()->pluck('ID_TYPE_SEANCE');
        foreach ($intervenants as &$intervenant){
            $intervenant['AllSelected'] = true;
            foreach ($types_seances as $types_seance){
                $intervenant['Selected-'.$types_seance] = true;
            }
            foreach ($intervenant['modules'] as &$module){

                foreach ($module['seances_intervenants'] as &$seance) {
                    $seance['SELECTED']  = IntervenantsSeancesSessionsModuleModel::where('ID_SEANCE',$seance['ID_SEANCE'])->where('ID_INTERVENANT',$intervenant['ID_INTERVENANT'])->count()>0;
                    if(!$seance['SELECTED']){
                        $intervenant['AllSelected'] = false;
                    }
                    foreach ($types_seances as $types_seance){
                        if(!$seance['SELECTED'] && $seance['ID_TYPE_SEANCE']==$types_seance){
                            $intervenant['Selected-'.$types_seance] = false;
                        }
                    }


                }
                unset($seance);
            }
            unset($module);
        }
        unset($intervenant);
        return collect($intervenants);

    }
    public function ListNotInSession($id){
        $inter =$this->ListBySession($id)->pluck('ID_INTERVENANT')->all();
        $admins = AdminsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','organisme_admins.ID_ORGANISME')
            ->leftJoin('users','organisme_admins.ID_ADMIN','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->whereNotIn('organisme_admins.ID_ADMIN',$inter)
            ->select(
                'organisme_admins.ID_ADMIN as ID_INTERVENANT',
                'organisme_admins.PHOTO',
                'organisme_admins.NOM',
                'organisme_admins.PRENOM',
                'organisme_admins.TELEPHONE',
                'users.email',
                DB::raw('"Admin" as TYPE'),
                DB::raw('false as "Add"')
            );
        return FormateursModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','formateurs.ID_ORGANISME')
            ->leftJoin('users','formateurs.ID_FORMATEUR','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->whereNotIn('formateurs.ID_FORMATEUR',$inter)
            ->select(
                'formateurs.ID_FORMATEUR as ID_INTERVENANT',
                'formateurs.PHOTO',
                'formateurs.NOM',
                'formateurs.PRENOM',
                'formateurs.TELEPHONE',
                'users.email',
                DB::raw('"Formateur" as TYPE'),
                DB::raw('false as "Add"')
            )
            ->union($admins)
            ->orderby('TYPE','ASC')
            ->orderby('NOM','ASC')
            ->get();

    }
    public function Get($id){
        return IntervenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_intervenants.ID_INTERVENANT')
            ->where('ID_INTERVENANT',$id)
            ->first();
    }
    public function Save(Request $request){
        $intervenant = New IntervenantsSessionsModuleModel();
        $intervenant->ID_INTERVENANT = $request->ID_INTERVENANT;
        $intervenant->ID_SESSION = $request->ID_SESSION;
        $intervenant->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $intervenant = IntervenantsSessionsModuleModel::where('ID_INTERVENANT',$id)->first();
        $intervenant->ID_INTERVENANT = $request->ID_INTERVENANT;
        $intervenant->ID_SESSION = $request->ID_SESSION;
        $intervenant->save();
        return response()->json(true);
    }

    public function Delete($id){
        IntervenantsSessionsModuleModel::where('ID_INTERVENANT',$id)->delete();
        return response()->json(true);
    }
}
