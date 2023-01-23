<?php

namespace App\Modules\FormateursModule\Http\Controllers;

use App\Models\User;
use App\Modules\FormateursModule\Http\Models\DocsFormateursModuleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\FormateursModule\Http\Models\FormateursModuleModel;
use Image;
use Auth;
use Illuminate\Support\Facades\Hash;

class FormateursModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return FormateursModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','formateurs.ID_ORGANISME')
            ->leftJoin('users','formateurs.ID_FORMATEUR','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('users.*','formateurs.*','organismes.NOM as NOM_ORGANISME')
            ->with('docs')
            ->get();
    }
    public function Get($id){
        return FormateursModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','formateurs.ID_ORGANISME')
            ->leftJoin('users','formateurs.ID_FORMATEUR','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('users.*','formateurs.*','organismes.NOM as NOM_ORGANISME')
            ->with('docs')
            ->findorfail($id);
    }
    public function Save(Request $request){
        $user =  New User();
        $user->email = $request->email;
        if(isset($request->password)){
            if(strlen($request->password)>0){
                $user->password = Hash::make($request->password);
            }
        }
        $user->TYPE = 'FORMATEUR';
        $user->save();

        $formateur = New FormateursModuleModel();

        $formateur->ID_FORMATEUR = $user->ID_USER;
        $formateur->ID_ORGANISME = $request->ID_ORGANISME;
        $formateur->CIVILITE = $request->CIVILITE;
        $formateur->NOM = $request->NOM;
        $formateur->PRENOM = $request->PRENOM;
        $formateur->EMAIL = $request->email;
        $formateur->CODE_INTERNE = $request->CODE_INTERNE;
        $formateur->NATIONALITE = $request->NATIONALITE;
        $formateur->NOM_NAISS = $request->NOM_NAISS;
        $formateur->VILLE_NAISS = $request->VILLE_NAISS;
        $formateur->DATE_NAISS = $request->DATE_NAISS == 'Invalid date'?null:$request->DATE_NAISS;
        $formateur->ID_LANGUE = $request->ID_LANGUE;
        $formateur->DEPARTEMENT_NAISS = $request->DEPARTEMENT_NAISS;
        $formateur->ADRESSE = $request->ADRESSE;
        $formateur->ZIP = $request->ZIP;
        $formateur->VILLE = $request->VILLE;
        $formateur->PAYS = $request->PAYS;
        $formateur->TELEPHONE = $request->TELEPHONE;
        $formateur->NUM_SEC_SOCIALE = $request->NUM_SEC_SOCIALE;
        $formateur->NUM_DECLARATION = $request->NUM_DECLARATION;
        $formateur->ID_CLIENT = $request->ID_CLIENT;
        $formateur->NUM_SIRET = $request->NUM_SIRET;
        $formateur->NUM_ASSURANCE = $request->NUM_ASSURANCE;
        $formateur->STATUT = $request->STATUT;
        $formateur->TARIF = $request->TARIF;
        $formateur->ID_TYPE_TARIF = $request->ID_TYPE_TARIF;
        $formateur->TVA = $request->TVA;
        $formateur->NUM_COMPTE = $request->NUM_COMPTE;
        $formateur->BIO = $request->BIO;
        $formateur->DIPLOMES = $request->DIPLOMES;
        $formateur->NOTE = $request->NOTE;
        $formateur->NOTE_COMPETENCES = $request->NOTE_COMPETENCES;
        $formateur->COMPETENCES = $request->COMPETENCES;
        $formateur->DATE = date('Y-m-d H:i:s');
        $formateur->save();
        for ( $i = 0; $i<10;$i++ ){
            if(isset($request['REF'.$i])){
                $doc = new DocsFormateursModuleModel();
                $doc->ID_FORMATEUR = $formateur->ID_FORMATEUR;
                $doc->TITRE = $request['TITRE'.$i];
                $filename = md5(date('Y-m-d H:i:s')).'.'.$request['REF'.$i]->getClientOriginalExtension();
                Image::make($request['REF'.$i])
                    ->save(public_path('uploads/docs_formateurs/' . $filename));
                $doc->REF = $filename;
                $doc->save();
            }
        }
        return response()->json(['result'=>true,'id'=>$formateur->ID_FORMATEUR]);
    }

    public function Update(Request $request,$id){
        $user =   User::findOrFail($id);
        $user->email = $request->email;
        if(isset($request->password)){
            if(strlen($request->password)>0){
                $user->password = Hash::make($request->password);
            }
        }
        $user->save();

        $formateur = FormateursModuleModel::findOrFail($id);
        $formateur->ID_ORGANISME = $request->ID_ORGANISME;
        $formateur->CIVILITE = $request->CIVILITE;
        $formateur->NOM = $request->NOM;
        $formateur->PRENOM = $request->PRENOM;
        $formateur->EMAIL = $request->email;
        $formateur->CODE_INTERNE = $request->CODE_INTERNE;
        $formateur->NATIONALITE = $request->NATIONALITE;
        $formateur->NOM_NAISS = $request->NOM_NAISS;
        $formateur->VILLE_NAISS = $request->VILLE_NAISS;
        $formateur->DATE_NAISS = $request->DATE_NAISS == 'Invalid date'?null:$request->DATE_NAISS;
        $formateur->ID_LANGUE = $request->ID_LANGUE;
        $formateur->DEPARTEMENT_NAISS = $request->DEPARTEMENT_NAISS;
        $formateur->ADRESSE = $request->ADRESSE;
        $formateur->ZIP = $request->ZIP;
        $formateur->VILLE = $request->VILLE;
        $formateur->PAYS = $request->PAYS;
        $formateur->TELEPHONE = $request->TELEPHONE;
        $formateur->NUM_SEC_SOCIALE = $request->NUM_SEC_SOCIALE;
        $formateur->NUM_DECLARATION = $request->NUM_DECLARATION;
        $formateur->ID_CLIENT = $request->ID_CLIENT;
        $formateur->NUM_SIRET = $request->NUM_SIRET;
        $formateur->NUM_ASSURANCE = $request->NUM_ASSURANCE;
        $formateur->STATUT = $request->STATUT;
        $formateur->TARIF = $request->TARIF;
        $formateur->ID_TYPE_TARIF = $request->ID_TYPE_TARIF;
        $formateur->TVA = $request->TVA;
        $formateur->NUM_COMPTE = $request->NUM_COMPTE;
        $formateur->BIO = $request->BIO;
        $formateur->DIPLOMES = $request->DIPLOMES;
        $formateur->NOTE = $request->NOTE;
        $formateur->NOTE_COMPETENCES = $request->NOTE_COMPETENCES;
        $formateur->COMPETENCES = $request->COMPETENCES;
        $formateur->save();
        for ( $i = 0; $i<10;$i++ ){
            if(isset($request['REF'.$i])){
                $doc = new DocsFormateursModuleModel();
                $doc->ID_FORMATEUR = $formateur->ID_FORMATEUR;
                $doc->TITRE = $request['TITRE'.$i];
                $filename = md5(date('Y-m-d H:i:s')).'.'.$request['REF'.$i]->getClientOriginalExtension();
                Image::make($request['REF'.$i])
                    ->save(public_path('uploads/docs_formateurs/' . $filename));
                $doc->REF = $filename;
                $doc->save();
            }
        }
        return response()->json(['result'=>true,'id'=>$formateur->ID_FORMATEUR]);
    }

    public function Delete($id){
        User::destroy($id);
        FormateursModuleModel::destroy($id);
        return response()->json(true);
    }
}
