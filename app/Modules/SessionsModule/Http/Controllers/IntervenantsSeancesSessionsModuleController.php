<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\IntervenantsSeancesSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class IntervenantsSeancesSessionsModuleController extends Controller
{
    public function Save(Request $request){
        $seances = New IntervenantsSeancesSessionsModuleModel();
        $seances->ID_INTERVENANT = $request->ID_INTERVENANT;
        $seances->ID_SEANCE = $request->ID_SEANCE;
        $seances->save();
        return response()->json(true);
    }

    public function Delete($id,$id_seance){
        IntervenantsSeancesSessionsModuleModel::where('ID_INTERVENANT',$id)->where('ID_SEANCE',$id_seance)->delete();
        return response()->json(true);
    }

    public function SaveMultiple(Request $request){
        $seances = json_decode($request->seances);
        foreach ($seances as $data) {

            IntervenantsSeancesSessionsModuleModel::updateOrCreate(
                [
                    'ID_SEANCE'=>$data->ID_SEANCE,
                    'ID_INTERVENANT'=>$data->ID_INTERVENANT
                ]
            );
        }
        return response()->json(true);
    }

    public function DeleteMultiple($data){
        $seances = json_decode($data);
        foreach ($seances as $seance){
            IntervenantsSeancesSessionsModuleModel::where('ID_INTERVENANT',$seance->ID_INTERVENANT)->where('ID_SEANCE',$seance->ID_SEANCE)->delete();
        }

        return response()->json(true);
    }
}
