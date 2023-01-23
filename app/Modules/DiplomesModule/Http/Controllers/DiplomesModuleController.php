<?php

namespace App\Modules\DiplomesModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\DiplomesModule\Http\Models\DiplomesModuleModel;

class DiplomesModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return DiplomesModuleModel::orderBy('DATE','DESC')->get();
    }
    public function Get($id){
        return DiplomesModuleModel::findOrFail($id);
    }
    public function Save(Request $request){
        $domaine = New DiplomesModuleModel();
        $domaine->NOM = $request->NOM;
        $domaine->DATE = date('Y-m-d H:i:s');
        $domaine->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $domaine = DiplomesModuleModel::findOrFail($id);
        $domaine->NOM = $request->NOM;
        $domaine->save();
        return response()->json(true);
    }

    public function Delete($id){
        DiplomesModuleModel::destroy($id);
        return response()->json(true);
    }
}
