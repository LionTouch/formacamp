<?php

namespace App\Modules\StagiairesModule\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\StagiairesModule\Http\Models\StagiairesModuleModel;
use Image;
use Auth;
class StagiairesModuleController extends Controller
{

    public function index()
    {
        return view('app');
    }

    public function List(){
        return StagiairesModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','stagiaires.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('stagiaires.*','organismes.NOM as NOM_ORGANISME')
            ->get();
    }
    public function Get($id){
        return StagiairesModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','stagiaires.ID_ORGANISME')
            ->where('organismes.ID_USER',Auth::id())
            ->select('stagiaires.*','organismes.NOM as NOM_ORGANISME')
            ->findOrFail($id);
    }

    public function Save(Request $request){
        $stagiaire = New StagiairesModuleModel();
        if(isset($request->PHOTO)){
            $filename = md5(date('Y-m-d H:i:s'));
            Image::make($request->PHOTO)
                ->save(public_path('uploads/users/stagiaires/' . $filename.'.'.$request->PHOTO->getClientOriginalExtension()));

            $stagiaire->PHOTO = $filename.'.'.$request->PHOTO->getClientOriginalExtension();
        }else{
            $stagiaire->PHOTO = 'default.png';
        }

        $stagiaire->EMAIL = $request->EMAIL;
        $stagiaire->ID_ORGANISME = $request->ID_ORGANISME;
        $stagiaire->CIVILITE = $request->CIVILITE;
        $stagiaire->NOM = $request->NOM;
        $stagiaire->PRENOM = $request->PRENOM;
        $stagiaire->ADRESSE = $request->ADRESSE;
        $stagiaire->ZIP = $request->ZIP;
        $stagiaire->VILLE = $request->VILLE;
        $stagiaire->PAYS = $request->PAYS;
        $stagiaire->TELEPHONE = $request->TELEPHONE;
        $stagiaire->TELEPHONE_2 = $request->TELEPHONE_2;
        $stagiaire->CODE = $request->CODE;
        $stagiaire->NATIONALITE = $request->NATIONALITE;
        $stagiaire->NOM_NAISS = $request->NOM_NAISS;
        $stagiaire->VILLE_NAISS = $request->VILLE_NAISS;
        $stagiaire->REGION_NAISS = $request->REGION_NAISS;
        $stagiaire->DATE_NAISS = $request->DATE_NAISS!= 'null'?$request->DATE_NAISS:NULL;
        $stagiaire->STATUT = $request->STATUT;
        $stagiaire->ID_CLIENT = $request->ID_CLIENT;
        $stagiaire->FONCTION = $request->FONCTION;
        $stagiaire->NOTES = $request->NOTES;
        $stagiaire->MENTION = $request->MENTION;
        $stagiaire->NUM_COMPTE_CLIENT = $request->NUM_COMPTE_CLIENT;
        $stagiaire->NUM_COMPTE_TVA = $request->NUM_COMPTE_TVA;
        $stagiaire->NUM_SEC = $request->NUM_SEC;
        $stagiaire->CATEG_SOC = $request->CATEG_SOC;
        $stagiaire->NATURE_CONTRAT_TRAV = $request->NATURE_CONTRAT_TRAV;
        $stagiaire->SALAIRE_HORAIRE_BRUT = $request->SALAIRE_HORAIRE_BRUT;
        $stagiaire->HANDICAP = $request->HANDICAP;
        $stagiaire->ID_LANGUE = $request->ID_LANGUE;
        $stagiaire->EMAIL = $request->EMAIL;
        $stagiaire->DATE = date('Y-m-d H:i:s');
        $stagiaire->save();
        return response()->json(['result'=>true,'id'=>$stagiaire->ID_STAGIAIRE]);
    }

    public function Update(Request $request,$id){
        $stagiaire = StagiairesModuleModel::findOrFail($id);

        if(isset($request->PHOTO) && gettype($request->PHOTO)!='string'){
            $filename = md5(date('Y-m-d H:i:s')).'.'.$request->PHOTO->getClientOriginalExtension();
            Image::make($request->PHOTO)
                ->save(public_path('uploads/users/stagiaires/' . $filename));

            $stagiaire->PHOTO = $filename;
        }
        $stagiaire->EMAIL = $request->EMAIL;
        $stagiaire->ID_ORGANISME = $request->ID_ORGANISME;
        $stagiaire->CIVILITE = $request->CIVILITE;
        $stagiaire->NOM = $request->NOM;
        $stagiaire->PRENOM = $request->PRENOM;
        $stagiaire->ADRESSE = $request->ADRESSE;
        $stagiaire->ZIP = $request->ZIP;
        $stagiaire->VILLE = $request->VILLE;
        $stagiaire->PAYS = $request->PAYS;
        $stagiaire->TELEPHONE = $request->TELEPHONE;
        $stagiaire->TELEPHONE_2 = $request->TELEPHONE_2;
        $stagiaire->CODE = $request->CODE;
        $stagiaire->NATIONALITE = $request->NATIONALITE;
        $stagiaire->NOM_NAISS = $request->NOM_NAISS;
        $stagiaire->VILLE_NAISS = $request->VILLE_NAISS;
        $stagiaire->REGION_NAISS = $request->REGION_NAISS;
        $stagiaire->DATE_NAISS = $request->DATE_NAISS;
        $stagiaire->STATUT = $request->STATUT;
        $stagiaire->ID_CLIENT = $request->ID_CLIENT;
        $stagiaire->FONCTION = $request->FONCTION;
        $stagiaire->NOTES = $request->NOTES;
        $stagiaire->MENTION = $request->MENTION;
        $stagiaire->NUM_COMPTE_CLIENT = $request->NUM_COMPTE_CLIENT;
        $stagiaire->NUM_COMPTE_TVA = $request->NUM_COMPTE_TVA;
        $stagiaire->NUM_SEC = $request->NUM_SEC;
        $stagiaire->CATEG_SOC = $request->CATEG_SOC;
        $stagiaire->NATURE_CONTRAT_TRAV = $request->NATURE_CONTRAT_TRAV;
        $stagiaire->SALAIRE_HORAIRE_BRUT = $request->SALAIRE_HORAIRE_BRUT;
        $stagiaire->HANDICAP = $request->HANDICAP;
        $stagiaire->ID_LANGUE = $request->ID_LANGUE;
        $stagiaire->save();
        return response()->json(['result'=>true,'id'=>$stagiaire->ID_STAGIAIRE]);
    }

    public function Delete($id){
        StagiairesModuleModel::destroy($id);
        return response()->json(true);
    }
}
