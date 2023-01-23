<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\IntervenantsEmargementsSessionsModulesModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class IntervenantsEmargementsSessionsModulesController extends Controller
{
    public function Save(Request $request){
        $em = new IntervenantsEmargementsSessionsModulesModel();
        $em->ID_SEANCE = $request->ID_SEANCE;
        $em->ID_INTERVENANT = $request->ID_INTERVENANT;
        $em->save();
        return response()->json(true);
    }
    public function Delete($id,$id_inter){
        IntervenantsEmargementsSessionsModulesModel::where('ID_SEANCE',$id)->where('ID_INTERVENANT',$id_inter)->delete();
        return response()->json(true);
    }
}
