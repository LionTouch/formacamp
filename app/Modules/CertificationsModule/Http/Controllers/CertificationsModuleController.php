<?php

namespace App\Modules\CertificationsModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\CertificationsModule\Http\Models\CertificationsModuleModel;

class CertificationsModuleController extends Controller
{
    public function List(){
        return CertificationsModuleModel::get();
    }

    public function Update(Request $request, $id){

        $certif = CertificationsModuleModel::findOrFail($id);
        $certif->TITRE = $request->TITRE;
        $certif->REF = $request->REF;
        $certif->save();
        return response()->json(true);
    }
    public function Delete($id){
        CertificationsModuleModel::destroy($id);
        return response()->json(true);
    }

}
