<?php

namespace App\Modules\FinanceursExternesModule\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\FinanceursExternesModule\Http\Models\FinanceursExternesModuleModel;
use Image;
use Auth;
class FinanceursExternesModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return FinanceursExternesModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','financeurs.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('financeurs.*','organismes.NOM as NOM_ORGANISME')
            ->get();
    }

    public function Get($id){
        return FinanceursExternesModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','financeurs.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('financeurs.*','organismes.NOM as NOM_ORGANISME')
            ->findOrFail($id);
    }

    public function Save(Request $request){
        $financeur = New FinanceursExternesModuleModel();

        $financeur->ID_ORGANISME = $request->ID_ORGANISME;
        $financeur->NOM = $request->NOM;
        $financeur->ADRESSE = $request->ADRESSE;
        $financeur->ZIP = $request->ZIP;
        $financeur->VILLE = $request->VILLE;
        $financeur->PAYS = $request->PAYS;
        $financeur->TELEPHONE = $request->TELEPHONE;
        $financeur->FAX = $request->FAX;
        $financeur->ID_TYPE_FINANCEUR = $request->ID_TYPE_FINANCEUR;
        $financeur->EMAIL = $request->EMAIL;
        $financeur->CODE_INTERNE = $request->CODE_INTERNE;
        $financeur->SIRET = $request->SIRET;
        $financeur->ID_LANGUE = $request->ID_LANGUE;
        $financeur->NOTE = $request->NOTE;
        $financeur->NUM_COMPTE_CLIENT = $request->NUM_COMPTE_CLIENT;
        $financeur->DATE = date('Y-m-d H:i:s');
        $financeur->save();
        return response()->json(['result'=>true,'id'=>$financeur->ID_FINANCEUR]);
    }

    public function Update(Request $request,$id){
        $financeur = FinanceursExternesModuleModel::findOrFail($id);
        $financeur->ID_ORGANISME = $request->ID_ORGANISME;
        $financeur->NOM = $request->NOM;
        $financeur->ADRESSE = $request->ADRESSE;
        $financeur->ZIP = $request->ZIP;
        $financeur->VILLE = $request->VILLE;
        $financeur->PAYS = $request->PAYS;
        $financeur->TELEPHONE = $request->TELEPHONE;
        $financeur->FAX = $request->FAX;
        $financeur->ID_TYPE_FINANCEUR = $request->ID_TYPE_FINANCEUR;
        $financeur->EMAIL = $request->EMAIL;
        $financeur->CODE_INTERNE = $request->CODE_INTERNE;
        $financeur->SIRET = $request->SIRET;
        $financeur->ID_LANGUE = $request->ID_LANGUE;
        $financeur->NOTE = $request->NOTE;
        $financeur->NUM_COMPTE_CLIENT = $request->NUM_COMPTE_CLIENT;
        $financeur->save();
        return response()->json(['result'=>true,'id'=>$financeur->ID_FINANCEUR]);
    }

    public function Delete($id){
        FinanceursExternesModuleModel::destroy($id);
        return response()->json(true);
    }
}
