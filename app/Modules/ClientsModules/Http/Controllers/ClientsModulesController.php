<?php

namespace App\Modules\ClientsModules\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\ClientsModules\Http\Models\ClientsModulesModel;
use Auth;
class ClientsModulesController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return ClientsModulesModel::leftjoin('organismes','organismes.ID_ORGANISME','clients.ID_ORGANISME')
            ->leftjoin('clients_type','clients_type.ID_TYPE_CLIENT','clients.ID_TYPE_CLIENT')
            ->where('organismes.ID_USER',Auth::id())
            ->select('clients.*','organismes.NOM as NOM_ORGANISME','clients_type.TITRE as TYPE_TITRE')
            ->get();
    }
    public function Get($id){
        return ClientsModulesModel::leftjoin('organismes','organismes.ID_ORGANISME','clients.ID_ORGANISME')
            ->leftjoin('clients_type','clients_type.ID_TYPE_CLIENT','clients.ID_TYPE_CLIENT')
            ->where('organismes.ID_USER',Auth::id())
            ->select('clients.*','organismes.NOM as NOM_ORGANISME','clients_type.TITRE as TYPE_TITRE')
            ->findOrFail($id);
    }
    public function Save(Request $request){
        $client = New ClientsModulesModel();
        $client->ID_ORGANISME = $request->ID_ORGANISME;
        $client->NOM = $request->NOM;
        $client->ID_TYPE_CLIENT = $request->ID_TYPE_CLIENT;
        $client->GROUPE = $request->GROUPE;
        $client->CODE_INTERNE = $request->CODE_INTERNE;
        $client->ADRESSE = $request->ADRESSE;
        $client->ZIP = $request->ZIP;
        $client->VILLE = $request->VILLE;
        $client->PAYS = $request->PAYS;
        $client->EMAIL = $request->EMAIL;
        $client->TELEPHONE = $request->TELEPHONE;
        $client->SITE = $request->SITE;
        $client->NUM_TVA = $request->NUM_TVA;
        $client->NUM_SIRET = $request->NUM_SIRET;
        $client->CODE_APE = $request->CODE_APE;
        $client->ID_LANGUE = $request->ID_LANGUE;
        $client->ETAT = $request->ETAT;
        $client->NOTE = $request->NOTE;
        $client->NUM_COMPTE_CLIENT = $request->NUM_COMPTE_CLIENT;
        $client->NUM_COMPTE_TVA = $request->NUM_COMPTE_TVA;
        $client->OPCO = $request->OPCO;
        $client->NUM_OPCO = $request->NUM_OPCO;
        $client->EFFECTIF = $request->EFFECTIF;
        $client->IDCC = $request->IDCC;
        $client->NACE = $request->NACE;
        $client->DATE = date('Y-m-d H:i:s');
        $client->save();
        return response()->json(['result'=>true,'id'=>$client->ID_CLIENT]);
    }

    public function Update(Request $request,$id){
        $client = ClientsModulesModel::findOrFail($id);
        $client->ID_ORGANISME = $request->ID_ORGANISME;
        $client->NOM = $request->NOM;
        $client->ID_TYPE_CLIENT = $request->ID_TYPE_CLIENT;
        $client->GROUPE = $request->GROUPE;
        $client->CODE_INTERNE = $request->CODE_INTERNE;
        $client->ADRESSE = $request->ADRESSE;
        $client->ZIP = $request->ZIP;
        $client->VILLE = $request->VILLE;
        $client->PAYS = $request->PAYS;
        $client->EMAIL = $request->EMAIL;
        $client->TELEPHONE = $request->TELEPHONE;
        $client->SITE = $request->SITE;
        $client->NUM_TVA = $request->NUM_TVA;
        $client->NUM_SIRET = $request->NUM_SIRET;
        $client->CODE_APE = $request->CODE_APE;
        $client->ID_LANGUE = $request->ID_LANGUE;
        $client->ETAT = $request->ETAT;
        $client->NOTE = $request->NOTE;
        $client->NUM_COMPTE_CLIENT = $request->NUM_COMPTE_CLIENT;
        $client->NUM_COMPTE_TVA = $request->NUM_COMPTE_TVA;
        $client->OPCO = $request->OPCO;
        $client->NUM_OPCO = $request->NUM_OPCO;
        $client->EFFECTIF = $request->EFFECTIF;
        $client->IDCC = $request->IDCC;
        $client->NACE = $request->NACE;
        $client->save();
        return response()->json(['result'=>true,'id'=>$client->ID_CLIENT]);
    }

    public function Delete($id){
        ClientsModulesModel::destroy($id);
        return response()->json(true);
    }
}
