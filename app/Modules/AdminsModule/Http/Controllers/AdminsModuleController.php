<?php

namespace App\Modules\AdminsModule\Http\Controllers;

use App\Models\User;
use App\Modules\CertificationsModule\Http\Models\CertificationsModuleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\AdminsModule\Http\Models\AdminsModuleModel;
use Illuminate\Support\Facades\Hash;
use Image;
use Auth;
class AdminsModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return AdminsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','organisme_admins.ID_ORGANISME')
            ->leftJoin('users','organisme_admins.ID_ADMIN','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('users.*','organisme_admins.*','organismes.NOM as NOM_ORGANISME')
            ->get()
            ->except('password');
    }
    public function Get($id){
        return AdminsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','organisme_admins.ID_ORGANISME')
            ->leftJoin('users','organisme_admins.ID_ADMIN','users.ID_USER')
            ->where('organismes.ID_USER',Auth::id())
            ->select('users.*','organisme_admins.*','organismes.NOM as NOM_ORGANISME')
            ->with('certifications')
            ->findOrFail($id)
            ->makeHidden('password');
    }
    public function Save(Request $request){

            $user =  New User();
            $admin =  New AdminsModuleModel();
            if(isset($request->PHOTO)){
                $filename = md5(date('Y-m-d H:i:s'));
                Image::make($request->PHOTO)
                    ->save(public_path('uploads/users/admins/' . $filename.'.'.$request->PHOTO->getClientOriginalExtension()));

                $admin->PHOTO = $filename.'.'.$request->PHOTO->getClientOriginalExtension();
            }else{
                $admin->PHOTO = 'default.png';
            }



        $user->email = $request->email;
        if(isset($request->password)){
            if(strlen($request->password)>0){
                $user->password = Hash::make($request->password);
            }
        }
        $user->DATE = date('Y-m-d H:i:s');
        $user->UPDATE_DATE = date('Y-m-d H:i:s');
        $user->TYPE = 'User';
        $user->save();

        $admin->ID_ADMIN = $user->ID_USER;
        $admin->ID_ORGANISME = $request->ID_ORGANISME;
        $admin->NOM = $request->NOM;
        $admin->PRENOM = $request->PRENOM;
        $admin->TELEPHONE = $request->TELEPHONE;
        $admin->NUM_VOIE = $request->NUM_VOIE;
        $admin->ID_REPETITION = $request->ID_REPETITION;
        $admin->ID_TYPE_VOIE = $request->ID_TYPE_VOIE;
        $admin->LIBELLE_VOIE = $request->LIBELLE_VOIE;
        $admin->ZIP = $request->ZIP;
        $admin->VILLE = $request->VILLE;
        $admin->PAYS = $request->PAYS;
        $admin->LIEU_SERVICE = $request->LIEU_SERVICE;
        $admin->ID_FUSEAU_HORAIRE = $request->ID_FUSEAU_HORAIRE;
        $admin->REGLEMENT = $request->REGLEMENT;
        $admin->DESCRIPTION = $request->DESCRIPTION;
        $admin->RESUME_CERTIF = $request->RESUME_CERTIF;
        $admin->HDM = $request->HDM;
        $admin->HFM = $request->HFM;
        $admin->HD = $request->HD;
        $admin->HF = $request->HF;
        $admin->FONCTION = $request->FONCTION;
        $admin->NUM_DEC = $request->NUM_DEC;
        $admin->REGION_ACQUISITON = $request->REGION_ACQUISITON;
        $admin->NUM_DPC = $request->NUM_DPC;
        $admin->ID_FORM_JURIDIQUE = $request->ID_FORM_JURIDIQUE;
        $admin->SIRET = $request->SIRET;
        $admin->CODE_APE_NAF = $request->CODE_APE_NAF;
        $admin->CAPITAL_SOCIAL = $request->CAPITAL_SOCIAL;
        $admin->EXONERATION = $request->EXONERATION;
        $admin->MICRO_ENTREPRISE = $request->MICRO_ENTREPRISE;
        $admin->FACTURATION = $request->FACTURATION;
        $admin->ID_MONNAIE = $request->ID_MONNAIE;
        $admin->SIGLE_TAXE = $request->SIGLE_TAXE;
        $admin->NUM_TVA = $request->NUM_TVA;
        $admin->TAUX_TVA = $request->TAUX_TVA;
        $admin->DATE_CLOTURE_COMTBLE = $request->DATE_CLOTURE_COMTBLE=='Invalid date-01'?null:$request->DATE_CLOTURE_COMTBLE;
        $admin->CODE_JOURNAL = $request->CODE_JOURNAL;
        $admin->COMPTE_CLIENT = $request->COMPTE_CLIENT;
        $admin->COMPTE_TVA = $request->COMPTE_TVA;
        $admin->COMPTE_PRODUIT_BPF = $request->COMPTE_PRODUIT_BPF;
        $admin->COMPTE_PRODUIT_FORMATION = $request->COMPTE_PRODUIT_FORMATION;
        $admin->COMPTE_PRODUIT_CONSULTING = $request->COMPTE_PRODUIT_CONSULTING;
        $admin->COMPTE_FRAIS_BPF = $request->COMPTE_FRAIS_BPF;
        $admin->COMPTE_FRAIS_FORMATION = $request->COMPTE_FRAIS_FORMATION;
        $admin->COMPTE_FRAIS_CONSULTING = $request->COMPTE_FRAIS_CONSULTING;
        $admin->COMPTE_OUTILS_BPF = $request->COMPTE_OUTILS_BPF;
        $admin->COMPTE_OUTILS_FORMATION = $request->COMPTE_OUTILS_FORMATION;
        $admin->COMPTE_OUTILS_CONSULTING = $request->COMPTE_OUTILS_CONSULTING;
        $admin->CODE_BANQUE = $request->CODE_BANQUE;
        $admin->CODE_GUICHET = $request->CODE_GUICHET;
        $admin->NUM_COMPTE_BANQUE = $request->NUM_COMPTE_BANQUE;
        $admin->RIB = $request->RIB;
        $admin->IBAN = $request->IBAN;
        $admin->BIC = $request->BIC;
        $admin->save();
        for ( $i = 0; $i<10;$i++ ){
            if(isset($request['REF'.$i])){
                $certif = new CertificationsModuleModel();
                $certif->ID_USER = $user->ID_USER;
                $certif->TITRE = $request['TITRE'.$i];
                $filename = md5(date('Y-m-d H:i:s')).'.'.$request['REF'.$i]->getClientOriginalExtension();
                Image::make($request['REF'.$i])
                    ->save(public_path('uploads/certifications/' . $filename));
                $certif->REF = $filename;
                $certif->save();
            }
        }
        return response()->json(['result'=>true,'id'=>$admin->ID_ADMIN]);

    }
    public function Update(Request $request, $id){

        $user = User::findOrFail($id);
        $admin = AdminsModuleModel::findOrFail($id);
        if(isset($request->PHOTO) && gettype($request->PHOTO)!='string'){
            $filename = md5(date('Y-m-d H:i:s')).'.'.$request->PHOTO->getClientOriginalExtension();
            Image::make($request->PHOTO)
                ->save(public_path('uploads/users/admins/' . $filename));

            $admin->PHOTO = $filename;
        }


        $user->email = $request->email;
        if(isset($request->password)){
            if(strlen($request->password)>0){
                $user->password = Hash::make($request->password);
            }
        }
        $user->UPDATE_DATE = date('Y-m-d H:i:s');
        $user->save();

        $admin->NOM = $request->NOM;
        $admin->PRENOM = $request->PRENOM;
        $admin->TELEPHONE = $request->TELEPHONE;
        $admin->NUM_VOIE = $request->NUM_VOIE;
        $admin->ID_REPETITION = $request->ID_REPETITION;
        $admin->ID_TYPE_VOIE = $request->ID_TYPE_VOIE;
        $admin->LIBELLE_VOIE = $request->LIBELLE_VOIE;
        $admin->ZIP = $request->ZIP;
        $admin->VILLE = $request->VILLE;
        $admin->PAYS = $request->PAYS;
        $admin->LIEU_SERVICE = $request->LIEU_SERVICE;
        $admin->ID_FUSEAU_HORAIRE = $request->ID_FUSEAU_HORAIRE;
        $admin->REGLEMENT = $request->REGLEMENT;
        $admin->DESCRIPTION = $request->DESCRIPTION;
        $admin->RESUME_CERTIF = $request->RESUME_CERTIF;
        $admin->HDM = $request->HDM;
        $admin->HFM = $request->HFM;
        $admin->HD = $request->HD;
        $admin->HF = $request->HF;
        $admin->FONCTION = $request->FONCTION;
        $admin->NUM_DEC = $request->NUM_DEC;
        $admin->REGION_ACQUISITON = $request->REGION_ACQUISITON;
        $admin->NUM_DPC = $request->NUM_DPC;
        $admin->ID_FORM_JURIDIQUE = $request->ID_FORM_JURIDIQUE;
        $admin->SIRET = $request->SIRET;
        $admin->CODE_APE_NAF = $request->CODE_APE_NAF;
        $admin->CAPITAL_SOCIAL = $request->CAPITAL_SOCIAL;
        $admin->EXONERATION = $request->EXONERATION;
        $admin->MICRO_ENTREPRISE = $request->MICRO_ENTREPRISE;
        $admin->FACTURATION = $request->FACTURATION;
        $admin->ID_MONNAIE = $request->ID_MONNAIE;
        $admin->SIGLE_TAXE = $request->SIGLE_TAXE;
        $admin->NUM_TVA = $request->NUM_TVA;
        $admin->TAUX_TVA = $request->TAUX_TVA;
        $admin->DATE_CLOTURE_COMTBLE = $request->DATE_CLOTURE_COMTBLE=='Invalid date-01'?null:$request->DATE_CLOTURE_COMTBLE;
        $admin->CODE_JOURNAL = $request->CODE_JOURNAL;
        $admin->COMPTE_CLIENT = $request->COMPTE_CLIENT;
        $admin->COMPTE_TVA = $request->COMPTE_TVA;
        $admin->COMPTE_PRODUIT_BPF = $request->COMPTE_PRODUIT_BPF;
        $admin->COMPTE_PRODUIT_FORMATION = $request->COMPTE_PRODUIT_FORMATION;
        $admin->COMPTE_PRODUIT_CONSULTING = $request->COMPTE_PRODUIT_CONSULTING;
        $admin->COMPTE_FRAIS_BPF = $request->COMPTE_FRAIS_BPF;
        $admin->COMPTE_FRAIS_FORMATION = $request->COMPTE_FRAIS_FORMATION;
        $admin->COMPTE_FRAIS_CONSULTING = $request->COMPTE_FRAIS_CONSULTING;
        $admin->COMPTE_OUTILS_BPF = $request->COMPTE_OUTILS_BPF;
        $admin->COMPTE_OUTILS_FORMATION = $request->COMPTE_OUTILS_FORMATION;
        $admin->COMPTE_OUTILS_CONSULTING = $request->COMPTE_OUTILS_CONSULTING;
        $admin->CODE_BANQUE = $request->CODE_BANQUE;
        $admin->CODE_GUICHET = $request->CODE_GUICHET;
        $admin->NUM_COMPTE_BANQUE = $request->NUM_COMPTE_BANQUE;
        $admin->RIB = $request->RIB;
        $admin->IBAN = $request->IBAN;
        $admin->BIC = $request->BIC;
        $admin->save();
        for ( $i = 0; $i<10;$i++ ){
            if(isset($request['REF'.$i])){
                $certif = new CertificationsModuleModel();
                $certif->ID_USER = $id;
                $certif->TITRE = $request['TITRE'.$i];
                $filename = md5(date('Y-m-d H:i:s')).'.'.$request['REF'.$i]->getClientOriginalExtension();
                Image::make($request['REF'.$i])
                    ->save(public_path('uploads/certifications/' . $filename));
                $certif->REF = $filename;
                $certif->save();
            }
        }
        return response()->json(['result'=>true,'id'=>$admin->ID_ADMIN]);

    }
    public function Delete($id){
         User::destroy($id);
         AdminsModuleModel::destroy($id);
        return response()->json(true);
    }
}
