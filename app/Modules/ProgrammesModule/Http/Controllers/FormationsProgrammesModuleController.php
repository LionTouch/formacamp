<?php

namespace App\Modules\ProgrammesModule\Http\Controllers;

use App\Modules\ProgrammesModule\Http\Models\FormationsProgrammesModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class FormationsProgrammesModuleController extends Controller
{
    public function List(){
        return FormationsProgrammesModuleModel::with('sous_formations')->get();
    }
    public function ListBySession($id){
        return FormationsProgrammesModuleModel::where('ID_SESSION',$id)
            ->orderBy('INDX')
            ->select(
                '*',
                DB::raw('"0" as TYPE')
            )
            ->with('sous_formations')
            ->get();

    }
    public function Get($id){
        return FormationsProgrammesModuleModel::with('sous_formations')->findOrFail($id);
    }
    public function Save(Request $request){
        $formations = json_decode($request->formations);
        foreach ($formations as $index=>$formation) {
            $sous_formations = $formation->sous_formations;
            if($formation->ID_FORMATION != 0){
                $frm = FormationsProgrammesModuleModel::findOrFail($formation->ID_FORMATION);
                $frm->INDX = $index;
                $frm->TEXT = $formation->TEXT;
                $frm->ID_SESSION = $formation->ID_SESSION;
                $frm->save();

                foreach ($sous_formations as $index=>$sous_formation){
                    if($sous_formation->ID_SUB_FORMATION != 0){
                        $sfr = SousFormationsProgrammesModuleModel::findOrFail($sous_formation->ID_SUB_FORMATION);
                        $sfr->INDX = $index;
                        $sfr->TEXT = $sous_formation->TEXT;
                        $sfr->ID_FORMATION = $frm->ID_FORMATION;
                        $sfr->save();
                    }else{
                        $sfr = new SousFormationsProgrammesModuleModel();
                        $sfr->INDX = $index;
                        $sfr->TEXT = $sous_formation->TEXT;
                        $sfr->ID_FORMATION = $frm->ID_FORMATION;
                        $sfr->save();
                    }
                }
            }else{
                $frm = new FormationsProgrammesModuleModel();
                $frm->INDX = $index;
                $frm->TEXT = $formation->TEXT;
                $frm->ID_PROGRAMME = $formation->ID_PROGRAMME;
                $frm->save();
                foreach ($sous_formations as $index=>$sous_formation){
                    if($sous_formation->ID_SUB_FORMATION != 0){
                        $sfr = SousFormationsProgrammesModuleModel::findOrFail($sous_formation->ID_SUB_FORMATION);
                        $sfr->INDX = $index;
                        $sfr->TEXT = $sous_formation->TEXT;
                        $sfr->ID_FORMATION = $frm->ID_FORMATION;
                        $sfr->save();
                    }else{
                        $sfr = new SousFormationsProgrammesModuleModel();
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
        $profil = FormationsProgrammesModuleModel::findOrFail($id);
        $profil->ID_SESSION = $request->ID_SESSION;
        $profil->INDX = $request->INDX;
        $profil->TEXT = $request->TEXT;
        $profil->save();
        return response()->json(true);
    }

    public function Delete($id){
        FormationsProgrammesModuleModel::destroy($id);
        SousFormationsProgrammesModuleModel::where('ID_FORMATION',$id)->delete();
        return response()->json(true);
    }
}
