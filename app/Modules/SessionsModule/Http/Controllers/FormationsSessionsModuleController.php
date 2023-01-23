<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\FormationsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SousFormationsSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
class FormationsSessionsModuleController extends Controller
{
    public function List(){
        return FormationsSessionsModuleModel::with('sous_formations')->get();
    }
    public function ListBySession($id){
        return FormationsSessionsModuleModel::where('ID_SESSION',$id)
            ->orderBy('INDX')
            ->select(
                '*',
                DB::raw('"0" as TYPE')
            )
            ->with('sous_formations')
            ->get();

    }
    public function Get($id){
        return FormationsSessionsModuleModel::with('sous_formations')->findOrFail($id);
    }
    public function Save(Request $request){
        $formations = json_decode($request->formations);
        foreach ($formations as $index=>$formation) {
            $sous_formations = $formation->sous_formations;
            if($formation->ID_FORMATION != 0){
                $frm = FormationsSessionsModuleModel::findOrFail($formation->ID_FORMATION);
                $frm->INDX = $index;
                $frm->TEXT = $formation->TEXT;
                $frm->ID_SESSION = $formation->ID_SESSION;
                $frm->save();
                
                foreach ($sous_formations as $index=>$sous_formation){
                    if($sous_formation->ID_SUB_FORMATION != 0){
                        $sfr = SousFormationsSessionsModuleModel::findOrFail($sous_formation->ID_SUB_FORMATION);
                        $sfr->INDX = $index;
                        $sfr->TEXT = $sous_formation->TEXT;
                        $sfr->ID_FORMATION = $frm->ID_FORMATION;
                        $sfr->save();
                    }else{
                        $sfr = new SousFormationsSessionsModuleModel();
                        $sfr->INDX = $index;
                        $sfr->TEXT = $sous_formation->TEXT;
                        $sfr->ID_FORMATION = $frm->ID_FORMATION;
                        $sfr->save();
                    }
                }
            }else{
                $frm = new FormationsSessionsModuleModel();
                $frm->INDX = $index;
                $frm->TEXT = $formation->TEXT;
                $frm->ID_SESSION = $formation->ID_SESSION;
                $frm->save();
                foreach ($sous_formations as $index=>$sous_formation){
                    if($sous_formation->ID_SUB_FORMATION != 0){
                        $sfr = SousFormationsSessionsModuleModel::findOrFail($sous_formation->ID_SUB_FORMATION);
                        $sfr->INDX = $index;
                        $sfr->TEXT = $sous_formation->TEXT;
                        $sfr->ID_FORMATION = $frm->ID_FORMATION;
                        $sfr->save();
                    }else{
                        $sfr = new SousFormationsSessionsModuleModel();
                        $sfr->INDX = $index;
                        $sfr->TEXT = $sous_formation->TEXT;
                        $sfr->ID_FORMATION = $frm->ID_FORMATION;
                        $sfr->save();
                    }
                }
            }
        }
        return response()->json(true);
    }


    public function Update(Request $request,$id){
        $profil = FormationsSessionsModuleModel::findOrFail($id);
        $profil->ID_SESSION = $request->ID_SESSION;
        $profil->INDX = $request->INDX;
        $profil->TEXT = $request->TEXT;
        $profil->save();
        return response()->json(true);
    }

    public function Delete($id){
        FormationsSessionsModuleModel::destroy($id);
        SousFormationsSessionsModuleModel::where('ID_FORMATION',$id)->delete();
        return response()->json(true);
    }
}
