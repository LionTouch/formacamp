<?php

namespace App\Modules\ProgrammesModule\Http\Controllers;

use App\Modules\ProgrammesModule\Http\Models\FormationsProgrammesModuleModel;
use App\Modules\ProgrammesModule\Http\Models\ObjectifsProgrammesModuleModel;
use App\Modules\ProgrammesModule\Http\Models\PotentielsProgrammesModuleModel;
use App\Modules\ProgrammesModule\Http\Models\PrerequisProgrammesModuleModel;
use App\Modules\ProgrammesModule\Http\Models\ProfilsApprenantsProgrammesModuleModel;
use App\Modules\ProgrammesModule\Http\Models\ProgrammesModuleModel;
use App\Modules\ProgrammesModule\Http\Models\SousFormationsProgrammesModuleModel;
use App\Modules\SessionsModule\Http\Models\ObjectifsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\ProfilsApprenantsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Str;
class ProgrammesModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }
    public function List(){
        return ProgrammesModuleModel::get();
    }

    public function Get($id){
        return ProgrammesModuleModel::with('prerequis')
            ->with('potentiels')
            ->with('objectifs')
            ->with('formations')
            ->findOrFail($id);
    }

    public function GetBySession($id){
        return ProgrammesModuleModel::join('sessions','sessions.ID_PROGRAMME','programmes.ID_PROGRAMME')
            ->with('prerequis')
            ->with('potentiels')
            ->with('objectifs')
            ->with('formations')
            ->where('sessions.ID_SESSION',$id)
            ->first();
    }

    public function Save(Request $request){
        $refs = ProgrammesModuleModel::select('REF')->get()->pluck('REF')->toArray();
        $ref = str_pad('PR'.rand(1,9999999999),12, "0", STR_PAD_LEFT);
        while(array_search($ref,$refs)>-1){
            $ref = str_pad('PR'.rand(1,9999999999),12, "0", STR_PAD_LEFT);
        }
        $programme = New ProgrammesModuleModel();
        $programme->REF = $ref;
        $programme->TITRE = $request->TITRE;
        $programme->DESCRIPTION = $request->DESCRIPTION;
        $programme->RESULTAT = $request->RESULTAT;
        $programme->OBTENTION = $request->OBTENTION;
        $programme->CERTIFICATION = $request->CERTIFICATION;
        $programme->VALIDITE = $request->VALIDITE;
        $programme->DATE = date('Y-m-d H:i:s');
        $programme->save();
        $potentiels = json_decode($request->potentiels);
        $prerequis = json_decode($request->prerequis);
        $objectifs = json_decode($request->objectifs);
        $formations = json_decode($request->formations);
        foreach ($objectifs as $index=>$objectif) {
            $obj = New ObjectifsProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $objectif->TEXT;
            $obj->save();
        }
        foreach ($formations as $index=>$formation) {
            $obj = New FormationsProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $formation->TEXT;
            $obj->save();
            foreach ($formation->sous_formations as $sub_index=>$sous_formation){
                $sf_obj = New SousFormationsProgrammesModuleModel();
                $sf_obj->ID_FORMATION = $obj->ID_FORMATION;
                $sf_obj->INDX = $sub_index;
                $sf_obj->TEXT = $sous_formation->TEXT;
                $sf_obj->save();
            }
        }
        foreach ($potentiels as $index=>$potentiel) {
            $obj = New PotentielsProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $potentiel->TEXT;
            $obj->save();
        }
        foreach ($prerequis as $index=>$prerequi) {
            $obj = New PrerequisProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $prerequi->TEXT;
            $obj->save();
        }
        if(isset($request->ID_SESSION)){
           $session = SessionsModuleModel::findOrFail($request->ID_SESSION);
           $session->ID_PROGRAMME = $programme->ID_PROGRAMME;
           $session->save();
        }
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $programme = ProgrammesModuleModel::findOrFail($id);
        $programme->TITRE = $request->TITRE;
        $programme->DESCRIPTION = $request->DESCRIPTION;
        $programme->RESULTAT = $request->RESULTAT;
        $programme->OBTENTION = $request->OBTENTION;
        $programme->CERTIFICATION = $request->CERTIFICATION;
        $programme->VALIDITE = $request->VALIDITE;
        $programme->save();
        $potentiels = json_decode($request->potentiels);
        $prerequis = json_decode($request->prerequis);
        $objectifs = json_decode($request->objectifs);
        $formations = json_decode($request->formations);
        $ids_formations = FormationsProgrammesModuleModel::where('ID_PROGRAMME',$programme->ID_PROGRAMME)->select('ID_FORMATION')->get()->pluck('ID_FORMATION');
        ObjectifsProgrammesModuleModel::where('ID_PROGRAMME',$programme->ID_PROGRAMME)->delete();
        FormationsProgrammesModuleModel::where('ID_PROGRAMME',$programme->ID_PROGRAMME)->delete();
        SousFormationsProgrammesModuleModel::whereIn('ID_FORMATION',$ids_formations)->delete();
        PotentielsProgrammesModuleModel::where('ID_PROGRAMME',$programme->ID_PROGRAMME)->delete();
        PrerequisProgrammesModuleModel::where('ID_PROGRAMME',$programme->ID_PROGRAMME)->delete();
        foreach ($objectifs as $index=>$objectif) {
            $obj = New ObjectifsProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $objectif->TEXT;
            $obj->save();
        }
        foreach ($formations as $index=>$formation) {
            $obj = New FormationsProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $formation->TEXT;
            $obj->save();
            foreach ($formation->sous_formations as $sub_index=>$sous_formation){
                $sf_obj = New SousFormationsProgrammesModuleModel();
                $sf_obj->ID_FORMATION = $obj->ID_FORMATION;
                $sf_obj->INDX = $sub_index;
                $sf_obj->TEXT = $sous_formation->TEXT;
                $sf_obj->save();
            }
        }
        foreach ($potentiels as $index=>$potentiel) {
            $obj = New PotentielsProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $potentiel->TEXT;
            $obj->save();
        }
        foreach ($prerequis as $index=>$prerequi) {
            $obj = New PrerequisProgrammesModuleModel();
            $obj->ID_PROGRAMME = $programme->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $prerequi->TEXT;
            $obj->save();
        }
        return response()->json(true);
    }

    public function Delete($id){
        ProgrammesModuleModel::destroy($id);
        $ids_formations = FormationsProgrammesModuleModel::where('ID_PROGRAMME',$id)->select('ID_FORMATION')->get()->pluck('ID_FORMATION');
        ObjectifsProgrammesModuleModel::where('ID_PROGRAMME',$id)->delete();
        FormationsProgrammesModuleModel::where('ID_PROGRAMME',$id)->delete();
        SousFormationsProgrammesModuleModel::whereIn('ID_FORMATION',$ids_formations)->delete();
        PotentielsProgrammesModuleModel::where('ID_PROGRAMME',$id)->delete();
        PrerequisProgrammesModuleModel::where('ID_PROGRAMME',$id)->delete();
        return response()->json(true);
    }
}
