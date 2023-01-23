<?php

namespace App\Modules\SallesModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\SallesModule\Http\Models\SallesModuleModel;
use Auth;
class SallesModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return SallesModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','salles.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('salles.*',
                'organismes.NOM as NOM_ORGANISME'
            )->orderBy('salles.DATE','DESC')
            ->get();
    }
    public function Get($id){
        return SallesModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','salles.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('salles.*','organismes.NOM as NOM_ORGANISME')
            ->findOrFail($id);
    }
    public function Save(Request $request){
        $salle = New SallesModuleModel();
        $salle->ID_ORGANISME = $request->ID_ORGANISME;
        $salle->NOM = $request->NOM;
        $salle->DATE = date('Y-m-d H:i:s');
        $salle->save();
        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $salle = SallesModuleModel::findOrFail($id);
        $salle->ID_ORGANISME = $request->ID_ORGANISME;
        $salle->NOM = $request->NOM;
        $salle->save();
        return response()->json(true);
    }

    public function Delete($id){
        SallesModuleModel::destroy($id);
        return response()->json(true);
    }

}
