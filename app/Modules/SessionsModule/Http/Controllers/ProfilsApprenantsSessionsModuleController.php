<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ProfilsApprenantsSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ProfilsApprenantsSessionsModuleController extends Controller
{
    public function List(){
        return ProfilsApprenantsSessionsModuleModel::get();
    }
    public function ListBySession($id){
        $data = ProfilsApprenantsSessionsModuleModel::where('ID_SESSION',$id)
            ->orderBy('INDX')
            ->get()
            ->groupBy('TYPE');
        $result = [];
        if(count($data)>0){
            foreach ($data as $index=>$d){
                array_push($result,
                    collect([
                        'TITLE'=> $index==0?"Clients potentiels":"Pré-requis",
                        'TYPE'=> $index==0?['0']:['1'],
                        'DATA'=> $d
                    ])
                );
            }
        }else{
            $result = [
                collect([
                    'TITLE'=> "Clients potentiels",
                    'TYPE'=> ['0'],
                    'DATA'=> []
                ]),
                collect([
                    'TITLE'=> "Pré-requis",
                    'TYPE'=> ['1'],
                    'DATA'=> []
                ])
            ];
        }


        return $result;
    }
    public function Get($id){
        return ProfilsApprenantsSessionsModuleModel::findOrFail($id);
    }
    public function Save(Request $request){
        $potentiels = json_decode($request->potentiels);
        $prerequis = json_decode($request->prerequis);
        foreach ($potentiels as $index=>$profil) {
            if($profil->ID_PROFIL == 0){
                $obj = New ProfilsApprenantsSessionsModuleModel();
            }else{
                $obj = ProfilsApprenantsSessionsModuleModel::findOrFail($profil->ID_PROFIL);
            }
            $obj->ID_SESSION = $profil->ID_SESSION;
            $obj->INDX = $index;
            $obj->TEXT = $profil->TEXT;
            $obj->TYPE = $profil->TYPE;
            $obj->save();
        }
        foreach ($prerequis as $index=>$profil) {
            if($profil->ID_PROFIL == 0){
                $obj = New ProfilsApprenantsSessionsModuleModel();
            }else{
                $obj = ProfilsApprenantsSessionsModuleModel::findOrFail($profil->ID_PROFIL);
            }
            $obj->ID_SESSION = $profil->ID_SESSION;
            $obj->INDX = $index;
            $obj->TEXT = $profil->TEXT;
            $obj->TYPE = $profil->TYPE;
            $obj->save();
        }

        return response()->json(true);
    }


    public function Update(Request $request,$id){
        $profil = ProfilsApprenantsSessionsModuleModel::findOrFail($id);
        $profil->ID_SESSION = $request->ID_SESSION;
        $profil->INDX = $request->INDX;
        $profil->TEXT = $request->TEXT;
        $profil->save();
        return response()->json(true);
    }

    public function Delete($id){
        ProfilsApprenantsSessionsModuleModel::destroy($id);
        return response()->json(true);
    }
}
