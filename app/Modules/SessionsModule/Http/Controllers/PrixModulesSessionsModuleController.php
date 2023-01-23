<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\PrixModulesSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PrixModulesSessionsModuleController extends Controller
{
    public function List(){
        return PrixModulesSessionsModuleModel::get();
    }
    public function ListByModule($id){
        return PrixModulesSessionsModuleModel::where('ID_MODULE',$id)
            ->get();
    }
    public function Get($id){
        return PrixModulesSessionsModuleModel::findOrFail($id);
    }
    public function Save(Request $request){
        $prix = New PrixModulesSessionsModuleModel();
        $prix->NOM = $request->NOM;
        $prix->ID_MODULE = $request->ID_MODULE;
        $prix->ID_TYPE_PRIX = $request->ID_TYPE_PRIX;
        $prix->ID_TARIF = $request->ID_TARIF;
        $prix->PRIX = $request->PRIX;
        $prix->TVA = $request->TVA;
        $prix->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $prix = PrixModulesSessionsModuleModel::findOrFail($id);
        $prix->NOM = $request->NOM;
        $prix->ID_MODULE = $request->ID_MODULE;
        $prix->ID_TYPE_PRIX = $request->ID_TYPE_PRIX;
        $prix->ID_TARIF = $request->ID_TARIF;
        $prix->PRIX = $request->PRIX;
        $prix->TVA = $request->TVA;
        $prix->save();
        return response()->json(true);
    }

    public function Delete($id){
        PrixModulesSessionsModuleModel::destroy($id);
        return response()->json(true);
    }
}
