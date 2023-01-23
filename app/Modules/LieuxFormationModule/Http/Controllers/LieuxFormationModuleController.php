<?php

namespace App\Modules\LieuxFormationModule\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\LieuxFormationModule\Http\Models\LieuxFormationModuleModel;
use Image;
use Auth;
class LieuxFormationModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return LieuxFormationModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','lieu_formation.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('lieu_formation.*','organismes.NOM as NOM_ORGANISME')
            ->get();
    }
    public function Get(Request $request,$id){
        return LieuxFormationModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','lieu_formation.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('lieu_formation.*','organismes.NOM as NOM_ORGANISME')
            ->findOrFail($id);
    }

    public function Save(Request $request){
        $lieu = New LieuxFormationModuleModel();

        $lieu->ID_ORGANISME = $request->ID_ORGANISME;
        $lieu->NOM = $request->NOM;
        $lieu->DESCRIPTION = $request->DESCRIPTION;
        $lieu->EQUIPEMENT = $request->EQUIPEMENT;
        $lieu->CAPACITE = $request->CAPACITE;
        $lieu->PRIX_DEMI = $request->PRIX_DEMI;
        $lieu->PRIX_JOURNEE = $request->PRIX_JOURNEE;
        $lieu->NUM_VOIE = $request->NUM_VOIE;
        $lieu->ID_REPETITION = $request->ID_REPETITION;
        $lieu->ID_TYPE_VOIE = $request->ID_TYPE_VOIE;
        $lieu->LIBELLE_VOIE = $request->LIBELLE_VOIE;
        $lieu->ZIP = $request->ZIP;
        $lieu->VILLE = $request->VILLE;
        $lieu->PAYS = $request->PAYS;
        $lieu->LIEU_SERVICE = $request->LIEU_SERVICE;
        $lieu->REGLEMENT = $request->REGLEMENT;
        $lieu->DESCRIPTION_MOYEN = $request->DESCRIPTION_MOYEN;
        $lieu->NOM_CONTACT = $request->NOM_CONTACT;
        $lieu->TEL_CONTACT = $request->TEL_CONTACT;
        $lieu->EMAIL_CONTACT = $request->EMAIL_CONTACT;
        $lieu->NOTE = $request->NOTE;
        $lieu->DATE = date('Y-m-d H:i:s');
        $lieu->save();
        return response()->json(['result'=>true,'id'=>$lieu->ID_LIEU_FORMATION]);
    }

    public function Update(Request $request,$id){
        $lieu = LieuxFormationModuleModel::findOrFail($id);
        $lieu->ID_ORGANISME = $request->ID_ORGANISME;
        $lieu->NOM = $request->NOM;
        $lieu->DESCRIPTION = $request->DESCRIPTION;
        $lieu->EQUIPEMENT = $request->EQUIPEMENT;
        $lieu->CAPACITE = $request->CAPACITE;
        $lieu->PRIX_DEMI = $request->PRIX_DEMI;
        $lieu->PRIX_JOURNEE = $request->PRIX_JOURNEE;
        $lieu->NUM_VOIE = $request->NUM_VOIE;
        $lieu->ID_REPETITION = $request->ID_REPETITION;
        $lieu->ID_TYPE_VOIE = $request->ID_TYPE_VOIE;
        $lieu->LIBELLE_VOIE = $request->LIBELLE_VOIE;
        $lieu->ZIP = $request->ZIP;
        $lieu->VILLE = $request->VILLE;
        $lieu->PAYS = $request->PAYS;
        $lieu->LIEU_SERVICE = $request->LIEU_SERVICE;
        $lieu->REGLEMENT = $request->REGLEMENT;
        $lieu->DESCRIPTION_MOYEN = $request->DESCRIPTION_MOYEN;
        $lieu->NOM_CONTACT = $request->NOM_CONTACT;
        $lieu->TEL_CONTACT = $request->TEL_CONTACT;
        $lieu->EMAIL_CONTACT = $request->EMAIL_CONTACT;
        $lieu->NOTE = $request->NOTE;
        $lieu->save();
        return response()->json(['result'=>true,'id'=>$lieu->ID_LIEU_FORMATION]);
    }

    public function Delete($id){
        LieuxFormationModuleModel::destroy($id);
        return response()->json(true);
    }
}
