<?php

namespace App\Modules\ProgrammesModule\Http\Controllers;

use App\Modules\ProgrammesModule\Http\Models\SousFormationsProgrammesModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SousFormationsProgrammesModuleController extends Controller
{
    public function List(){
        return SousFormationsProgrammesModuleModel::get();
    }

    public function Get($id){
        return SousFormationsProgrammesModuleModel::findOrFail($id);
    }

    public function Save(Request $request){
        $sous_formation = new SousFormationsProgrammesModuleModel();
        $sous_formation->ID_FORMATION = $request->ID_FORMATION;
        $sous_formation->INDX = $request->INDX;
        $sous_formation->TEXT = $request->TEXT;
        $sous_formation->save();

        return response()->json(true);
    }


    public function Update(Request $request,$id){
        $sous_formation = SousFormationsProgrammesModuleModel::findOrFail($id);
        $sous_formation->ID_FORMATION = $request->ID_FORMATION;
        $sous_formation->INDX = $request->INDX;
        $sous_formation->TEXT = $request->TEXT;
        $sous_formation->save();
        return response()->json(true);
    }

    public function Delete($id){
        SousFormationsProgrammesModuleModel::destroy($id);
        return response()->json(true);
    }
}
