<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\SeancesModulesSessionsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
class SeancesModulesSessionsController extends Controller
{
    public function List(){
        return SeancesModulesSessionsModel::get();
    }
    public function ListByModule($id){
        return SeancesModulesSessionsModel::leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->leftjoin('sessions_modules_types_seances','sessions_modules_types_seances.ID_TYPE_SEANCE','sessions_modules_seances.ID_TYPE_SEANCE')
            ->leftjoin('salles','salles.ID_SALLE','sessions_modules_seances.ID_SALLE')
            ->select(
                'salles.NOM',
                'sessions_modules_seances.*',
                'sessions_modules_types_seances.NOM as NOM_TYPE_SEANCE',
                'sessions_modules_types_seances.DEBUT as MIN',
                'sessions_modules_types_seances.FIN as MAX',
                DB::raw('CONCAT( DATE_FORMAT(HD,"%H:%i"), "-", DATE_FORMAT(HF,"%H:%i")," - Salle: ",CAST(salles.NOM AS CHAR CHARACTER SET utf8) ) as title'),
                DB::raw('CONCAT( sessions_modules_seances.DATE,"T",DATE_FORMAT(HD,"%H:%i"),":00+00:00") as start'),
                DB::raw('CONCAT( sessions_modules_seances.DATE,"T",DATE_FORMAT(HF,"%H:%i"),":00+00:00") as end'),
                'sessions_modules_seances.ID_SEANCE as id'
            )
            ->where('sessions_modules_seances.ID_MODULE',$id)
            ->orderBy('DATE')->orderBy('HD')
            ->get();
    }
    public function ListBySession($id){
        return SeancesModulesSessionsModel::leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->leftjoin('sessions_modules_types_seances','sessions_modules_types_seances.ID_TYPE_SEANCE','sessions_modules_seances.ID_TYPE_SEANCE')
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_modules.ID_SESSION')
            ->leftjoin('salles','salles.ID_SALLE','sessions_modules_seances.ID_SALLE')
            ->where('sessions.ID_SESSION',$id)
            ->select(
                'sessions_modules.*',
                'sessions_modules_seances.*',
                'sessions_modules_types_seances.NOM as NOM_TYPE_SEANCE',
                'sessions.NOM as NOM_SESSION',
                'salles.NOM as NOM_SALLE',
                DB::raw('CONCAT( DATE_FORMAT(sessions_modules_seances.DATE,"%e/%c/%Y")," ",CAST(sessions_modules_types_seances.NOM AS CHAR CHARACTER SET utf8)," ", DATE_FORMAT(HD,"%H:%i"), "-", DATE_FORMAT(HF,"%H:%i")) as title'),
            )
            ->orderBy('sessions_modules_seances.ID_MODULE')
            ->orderBy('DATE')
            ->orderBy('HD')
            ->get();
    }
    public function Get($id){
        return SeancesModulesSessionsModel::findOrFail($id);
    }
    public function Save(Request $request){

        $seance = New SeancesModulesSessionsModel();
        $seance->ID_SEANCE = $request->ID_SEANCE;
        $seance->ID_SALLE = $request->ID_SALLE;
        $seance->ID_TYPE_SEANCE = $request->ID_TYPE_SEANCE;
        $seance->HD = $request->HD;
        $seance->HF = $request->HF;
        $seance->DATE = $request->DATE;
        $seance->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $seance = SeancesModulesSessionsModel::findOrFail($id);
        $seance->ID_MODULE = $request->ID_MODULE;
        $seance->ID_SALLE = $request->ID_SALLE;
        $seance->ID_TYPE_SEANCE = $request->ID_TYPE_SEANCE;
        $seance->HD = $request->HD;
        $seance->HF = $request->HF;
        $seance->DATE = $request->DATE;
        $seance->save();
        return response()->json(true);
    }

    public function Delete($id){
        SeancesModulesSessionsModel::destroy($id);
        return response()->json(true);
    }

    public function SaveMultiple(Request $request){
        $seances = json_decode($request->seances);
        $dates = json_decode($request->dates);


        foreach ($seances as $seance) {
            $hd = new \DateTime($seance->HD);
            $hf = new \DateTime($seance->HF);
            $diff= $hf->diff($hd);
            if($seance->ID_SEANCE != 0){
                $obj = SeancesModulesSessionsModel::findOrFail($seance->ID_SEANCE);
                $obj->ID_SALLE = $seance->ID_SALLE ;
                $obj->ID_MODULE = $seance->ID_MODULE ;
                $obj->ID_TYPE_SEANCE = $seance->ID_TYPE_SEANCE ;
                $obj->HD = $seance->HD ;
                $obj->HF = $seance->HF ;
                $obj->DUREE = $diff->h + $diff->i/60 ;
                $obj->save();
            }else{
                foreach ($dates as $date){

                    $obj = New SeancesModulesSessionsModel();
                    $obj->ID_SALLE = $seance->ID_SALLE ;
                    $obj->ID_MODULE = $seance->ID_MODULE ;
                    $obj->ID_TYPE_SEANCE = $seance->ID_TYPE_SEANCE ;
                    $obj->HD = $seance->HD ;
                    $obj->HF = $seance->HF ;
                    $obj->DUREE = $diff->h + $diff->i/60 ;
                    $obj->DATE = $date ;
                    $obj->save();
                }

            }

        }



        return response()->json(true);
    }

}
