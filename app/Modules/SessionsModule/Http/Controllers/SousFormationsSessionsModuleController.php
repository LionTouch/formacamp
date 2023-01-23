<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\SousFormationsSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SousFormationsSessionsModuleController extends Controller
{
    public function List(){
        return SousFormationsSessionsModuleModel::get();
    }

    public function Get($id){
        return SousFormationsSessionsModuleModel::findOrFail($id);
    }

    public function Save(Request $request){
        $sous_formation = new SousFormationsSessionsModuleModel();
        $sous_formation->ID_FORMATION = $request->ID_FORMATION;
        $sous_formation->INDX = $request->INDX;
        $sous_formation->TEXT = $request->TEXT;
        $sous_formation->save();

        return response()->json(true);
    }


    public function Update(Request $request,$id){
        $sous_formation = SousFormationsSessionsModuleModel::findOrFail($id);
        $sous_formation->ID_FORMATION = $request->ID_FORMATION;
        $sous_formation->INDX = $request->INDX;
        $sous_formation->TEXT = $request->TEXT;
        $sous_formation->save();
        return response()->json(true);
    }

    public function Delete($id){
        SousFormationsSessionsModuleModel::destroy($id);
        return response()->json(true);
    }
}
