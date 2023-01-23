<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ApprenantsEmargementsSessionsModulesModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ApprenantsEmargementsSessionsModulesController extends Controller
{
    public function Save(Request $request){
        $em = new ApprenantsEmargementsSessionsModulesModel();
        $em->ID_SEANCE = $request->ID_SEANCE;
        $em->ID_APPRENANT = $request->ID_APPRENANT;
        $em->save();
        return response()->json(true);
    }
    public function Delete($id,$id_apprenant){
        ApprenantsEmargementsSessionsModulesModel::where('ID_SEANCE',$id)->where('ID_APPRENANT',$id_apprenant)->delete();
        return response()->json(true);
    }
}
