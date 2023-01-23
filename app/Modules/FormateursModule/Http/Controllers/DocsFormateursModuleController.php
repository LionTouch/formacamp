<?php

namespace App\Modules\FormateursModule\Http\Controllers;

use App\Modules\FormateursModule\Http\Models\DocsFormateursModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DocsFormateursModuleController extends Controller
{
    public function List(){
        return DocsFormateursModuleModel::get();
    }
    public function Update(Request $request, $id){

        $doc = DocsFormateursModuleModel::findOrFail($id);
        $doc->TITRE = $request->TITRE;
        $doc->REF = $request->REF;
        $doc->save();
        return response()->json(true);
    }
    public function Delete($id){
        DocsFormateursModuleModel::destroy($id);
        return response()->json(true);
    }
}
