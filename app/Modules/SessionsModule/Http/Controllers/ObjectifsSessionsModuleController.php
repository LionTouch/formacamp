<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ObjectifsSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ObjectifsSessionsModuleController extends Controller
{
    public function List(){
        return ObjectifsSessionsModuleModel::get();
    }
    public function ListBySession($id){
        return ObjectifsSessionsModuleModel::where('ID_SESSION',$id)->orderBy('INDX')->get();
    }
    public function Get($id){
        return ObjectifsSessionsModuleModel::findOrFail($id);
    }
    public function Save(Request $request){
        $objectifs = json_decode($request->objectifs);
        foreach ($objectifs as $index=>$objectif) {
            if($objectif->ID_OBJECTIF == 0){
                $obj = New ObjectifsSessionsModuleModel();
            }else{
                $obj = ObjectifsSessionsModuleModel::findOrFail($objectif->ID_OBJECTIF);
            }
            $obj->ID_SESSION = $objectif->ID_SESSION;
            $obj->INDX = $index;
            $obj->TEXT = $objectif->TEXT;
            $obj->save();
        }

        return response()->json(true);
    }


    public function Update(Request $request,$id){
        $objectif = ObjectifsSessionsModuleModel::findOrFail($id);
        $objectif->ID_SESSION = $request->ID_SESSION;
        $objectif->INDX = $request->INDX;
        $objectif->TEXT = $request->TEXT;
        $objectif->save();
        return response()->json(true);
    }

    public function Delete($id){
        ObjectifsSessionsModuleModel::destroy($id);
        return response()->json(true);
    }
}
