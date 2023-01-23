<?php

namespace App\Modules\ActionsFormationModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\ActionsFormationModule\Http\Models\ActionsFormationModuleModel;

class ActionsFormationModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return ActionsFormationModuleModel::orderBy('DATE','DESC')->get();
    }
    public function Get($id){
        return ActionsFormationModuleModel::findOrFail($id);
    }
    public function Save(Request $request){
        $domaine = New ActionsFormationModuleModel();
        $domaine->NOM = $request->NOM;
        $domaine->DATE = date('Y-m-d H:i:s');
        $domaine->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $domaine = ActionsFormationModuleModel::findOrFail($id);
        $domaine->NOM = $request->NOM;
        $domaine->save();
        return response()->json(true);
    }

    public function Delete($id){
        ActionsFormationModuleModel::destroy($id);
        return response()->json(true);
    }
}
