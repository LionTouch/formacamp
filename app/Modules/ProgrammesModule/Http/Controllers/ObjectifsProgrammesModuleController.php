<?php

namespace App\Modules\ProgrammesModule\Http\Controllers;

use App\Modules\ProgrammesModule\Http\Models\ObjectifsProgrammesModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ObjectifsProgrammesModuleController extends Controller
{
    public function List(){
        return ObjectifsProgrammesModuleModel::get();
    }
    public function ListBySession($id){
        return ObjectifsProgrammesModuleModel::where('ID_SESSION',$id)->orderBy('INDX')->get();
    }
    public function Get($id){
        return ObjectifsProgrammesModuleModel::findOrFail($id);
    }
    public function Save(Request $request){
        $objectifs = json_decode($request->objectifs);
        foreach ($objectifs as $index=>$objectif) {
            if($objectif->ID_OBJECTIF == 0){
                $obj = New ObjectifsProgrammesModuleModel();
            }else{
                $obj = ObjectifsProgrammesModuleModel::findOrFail($objectif->ID_OBJECTIF);
            }
            $obj->ID_PROGRAMME = $objectif->ID_PROGRAMME;
            $obj->INDX = $index;
            $obj->TEXT = $objectif->TEXT;
            $obj->save();
        }

        return response()->json(true);
    }


    public function Update(Request $request,$id){
        $objectif = ObjectifsProgrammesModuleModel::findOrFail($id);
        $objectif->ID_SESSION = $request->ID_SESSION;
        $objectif->INDX = $request->INDX;
        $objectif->TEXT = $request->TEXT;
        $objectif->save();
        return response()->json(true);
    }

    public function Delete($id){
        ObjectifsProgrammesModuleModel::destroy($id);
        return response()->json(true);
    }
}
