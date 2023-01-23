<?php

namespace App\Modules\DomainesModule\Http\Controllers;

use App\Modules\DomainesModule\Http\Models\GroupDomainesModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\DomainesModule\Http\Models\DomainesModuleModel;

class DomainesModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return DomainesModuleModel::orderBy('DATE','DESC')->get();
    }
    public function Get($id){
        return DomainesModuleModel::findOrFail($id);
    }
    public function Save(Request $request){
        $domaine = New DomainesModuleModel();
        $domaine->NOM = $request->NOM;
        $domaine->DATE = date('Y-m-d H:i:s');
        $domaine->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $domaine = DomainesModuleModel::findOrFail($id);
        $domaine->NOM = $request->NOM;
        $domaine->save();
        return response()->json(true);
    }

    public function Delete($id){
        DomainesModuleModel::destroy($id);
        return response()->json(true);
    }
}
