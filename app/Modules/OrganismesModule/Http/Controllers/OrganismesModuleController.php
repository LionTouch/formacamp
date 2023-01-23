<?php

namespace App\Modules\OrganismesModule\Http\Controllers;

use App\Models\User;
use App\Modules\CertificationsModule\Http\Models\CertificationsOrganismeModuleModel;
use App\Modules\OrganismesModule\Http\Models\OrganismesModuleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Image;
use Auth;
class OrganismesModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return OrganismesModuleModel::where('ID_USER',Auth::id())->with('certifications')->get();
    }
    public function Get($id){
        return  OrganismesModuleModel::with('certifications')->findOrFail($id);
    }
    public function Save(Request $request){

        $organisme =  New OrganismesModuleModel();

        if(isset($request->LOGO)){
            $filename = md5(date('Y-m-d H:i:s'));
            Image::make($request->LOGO)
                ->save(public_path('uploads/organismes/' . $filename.'.'.$request->LOGO->getClientOriginalExtension()));

            $organisme->LOGO = $filename.'.'.$request->LOGO->getClientOriginalExtension();
        }else{
            $organisme->LOGO = 'default.png';
        }


        $organisme->ID_USER = Auth::id();
        $organisme->NOM = $request->NOM;
        $organisme->COULEUR_MARQUE = $request->COULEUR_MARQUE;
        $organisme->TELEPHONE = $request->TELEPHONE;
        $organisme->NUM_VOIE = $request->NUM_VOIE;
        $organisme->ID_REPETITION = $request->ID_REPETITION;
        $organisme->ID_TYPE_VOIE = $request->ID_TYPE_VOIE;
        $organisme->LIBELLE_VOIE = $request->LIBELLE_VOIE;
        $organisme->ZIP = $request->ZIP;
        $organisme->VILLE = $request->VILLE;
        $organisme->PAYS = $request->PAYS;
        $organisme->LIEU_SERVICE = $request->LIEU_SERVICE;
        $organisme->ID_FUSEAU_HORAIRE = $request->ID_FUSEAU_HORAIRE;
        $organisme->REGLEMENT = $request->REGLEMENT;
        $organisme->DESCRIPTION = $request->DESCRIPTION;
        $organisme->RESUME_CERTIF = $request->RESUME_CERTIF;
        $organisme->HDM = $request->HDM;
        $organisme->HFM = $request->HFM;
        $organisme->HD = $request->HD;
        $organisme->HF = $request->HF;
        $organisme->FONCTION = $request->FONCTION;
        $organisme->NUM_DEC = $request->NUM_DEC;
        $organisme->REGION_ACQUISITON = $request->REGION_ACQUISITON;
        $organisme->NUM_DPC = $request->NUM_DPC;
        $organisme->ID_FORM_JURIDIQUE = $request->ID_FORM_JURIDIQUE;
        $organisme->SIRET = $request->SIRET;
        $organisme->CODE_APE_NAF = $request->CODE_APE_NAF;
        $organisme->CAPITAL_SOCIAL = $request->CAPITAL_SOCIAL;
        $organisme->EXONERATION = $request->EXONERATION;
        $organisme->MICRO_ENTREPRISE = $request->MICRO_ENTREPRISE;
        $organisme->FACTURATION = $request->FACTURATION;
        $organisme->ID_MONNAIE = $request->ID_MONNAIE;
        $organisme->SIGLE_TAXE = $request->SIGLE_TAXE;
        $organisme->NUM_TVA = $request->NUM_TVA;
        $organisme->TAUX_TVA = $request->TAUX_TVA;
        $organisme->DATE_CLOTURE_COMTBLE = $request->DATE_CLOTURE_COMTBLE=='Invalid date-01'?null:$request->DATE_CLOTURE_COMTBLE;
        $organisme->CODE_JOURNAL = $request->CODE_JOURNAL;
        $organisme->COMPTE_CLIENT = $request->COMPTE_CLIENT;
        $organisme->COMPTE_TVA = $request->COMPTE_TVA;
        $organisme->COMPTE_PRODUIT_BPF = $request->COMPTE_PRODUIT_BPF;
        $organisme->COMPTE_PRODUIT_FORMATION = $request->COMPTE_PRODUIT_FORMATION;
        $organisme->COMPTE_PRODUIT_CONSULTING = $request->COMPTE_PRODUIT_CONSULTING;
        $organisme->COMPTE_FRAIS_BPF = $request->COMPTE_FRAIS_BPF;
        $organisme->COMPTE_FRAIS_FORMATION = $request->COMPTE_FRAIS_FORMATION;
        $organisme->COMPTE_FRAIS_CONSULTING = $request->COMPTE_FRAIS_CONSULTING;
        $organisme->COMPTE_OUTILS_BPF = $request->COMPTE_OUTILS_BPF;
        $organisme->COMPTE_OUTILS_FORMATION = $request->COMPTE_OUTILS_FORMATION;
        $organisme->COMPTE_OUTILS_CONSULTING = $request->COMPTE_OUTILS_CONSULTING;
        $organisme->CODE_BANQUE = $request->CODE_BANQUE;
        $organisme->CODE_GUICHET = $request->CODE_GUICHET;
        $organisme->NUM_COMPTE_BANQUE = $request->NUM_COMPTE_BANQUE;
        $organisme->RIB = $request->RIB;
        $organisme->IBAN = $request->IBAN;
        $organisme->BIC = $request->BIC;
        $organisme->save();
        for ( $i = 0; $i<10;$i++ ){
            if(isset($request['REF'.$i])){
                $certif = new CertificationsOrganismeModuleModel();
                $certif->ID_ORGANISME = $organisme->ID_ORGANISME;
                $certif->TITRE = $request['TITRE'.$i];
                $filename = md5(date('Y-m-d H:i:s')).'.'.$request['REF'.$i]->getClientOriginalExtension();
                Image::make($request['REF'.$i])
                    ->save(public_path('uploads/certifications/' . $filename));
                $certif->REF = $filename;
                $certif->save();
            }
        }
        return response()->json(['result'=>true,'id'=>$organisme->ID_ORGANISME]);

    }
    public function Update(Request $request, $id){
        $organisme = OrganismesModuleModel::findOrFail($id);

        if(isset($request->LOGO) && gettype($request->LOGO)!='string'){
            $filename = md5(date('Y-m-d H:i:s'));
            Image::make($request->LOGO)
                ->save(public_path('uploads/organismes/' . $filename.'.'.$request->LOGO->getClientOriginalExtension()));

            $organisme->LOGO = $filename.'.'.$request->LOGO->getClientOriginalExtension();
        }


        $organisme->NOM = $request->NOM;
        $organisme->COULEUR_MARQUE = $request->COULEUR_MARQUE;
        $organisme->TELEPHONE = $request->TELEPHONE;
        $organisme->NUM_VOIE = $request->NUM_VOIE;
        $organisme->ID_REPETITION = $request->ID_REPETITION;
        $organisme->ID_TYPE_VOIE = $request->ID_TYPE_VOIE;
        $organisme->LIBELLE_VOIE = $request->LIBELLE_VOIE;
        $organisme->ZIP = $request->ZIP;
        $organisme->VILLE = $request->VILLE;
        $organisme->PAYS = $request->PAYS;
        $organisme->LIEU_SERVICE = $request->LIEU_SERVICE;
        $organisme->ID_FUSEAU_HORAIRE = $request->ID_FUSEAU_HORAIRE;
        $organisme->REGLEMENT = $request->REGLEMENT;
        $organisme->DESCRIPTION = $request->DESCRIPTION;
        $organisme->RESUME_CERTIF = $request->RESUME_CERTIF;
        $organisme->HDM = $request->HDM;
        $organisme->HFM = $request->HFM;
        $organisme->HD = $request->HD;
        $organisme->HF = $request->HF;
        $organisme->FONCTION = $request->FONCTION;
        $organisme->NUM_DEC = $request->NUM_DEC;
        $organisme->REGION_ACQUISITON = $request->REGION_ACQUISITON;
        $organisme->NUM_DPC = $request->NUM_DPC;
        $organisme->ID_FORM_JURIDIQUE = $request->ID_FORM_JURIDIQUE;
        $organisme->SIRET = $request->SIRET;
        $organisme->CODE_APE_NAF = $request->CODE_APE_NAF;
        $organisme->CAPITAL_SOCIAL = $request->CAPITAL_SOCIAL;
        $organisme->EXONERATION = $request->EXONERATION;
        $organisme->MICRO_ENTREPRISE = $request->MICRO_ENTREPRISE;
        $organisme->FACTURATION = $request->FACTURATION;
        $organisme->ID_MONNAIE = $request->ID_MONNAIE;
        $organisme->SIGLE_TAXE = $request->SIGLE_TAXE;
        $organisme->NUM_TVA = $request->NUM_TVA;
        $organisme->TAUX_TVA = $request->TAUX_TVA;
        $organisme->DATE_CLOTURE_COMTBLE = $request->DATE_CLOTURE_COMTBLE=='Invalid date-01'?null:$request->DATE_CLOTURE_COMTBLE;
        $organisme->CODE_JOURNAL = $request->CODE_JOURNAL;
        $organisme->COMPTE_CLIENT = $request->COMPTE_CLIENT;
        $organisme->COMPTE_TVA = $request->COMPTE_TVA;
        $organisme->COMPTE_PRODUIT_BPF = $request->COMPTE_PRODUIT_BPF;
        $organisme->COMPTE_PRODUIT_FORMATION = $request->COMPTE_PRODUIT_FORMATION;
        $organisme->COMPTE_PRODUIT_CONSULTING = $request->COMPTE_PRODUIT_CONSULTING;
        $organisme->COMPTE_FRAIS_BPF = $request->COMPTE_FRAIS_BPF;
        $organisme->COMPTE_FRAIS_FORMATION = $request->COMPTE_FRAIS_FORMATION;
        $organisme->COMPTE_FRAIS_CONSULTING = $request->COMPTE_FRAIS_CONSULTING;
        $organisme->COMPTE_OUTILS_BPF = $request->COMPTE_OUTILS_BPF;
        $organisme->COMPTE_OUTILS_FORMATION = $request->COMPTE_OUTILS_FORMATION;
        $organisme->COMPTE_OUTILS_CONSULTING = $request->COMPTE_OUTILS_CONSULTING;
        $organisme->CODE_BANQUE = $request->CODE_BANQUE;
        $organisme->CODE_GUICHET = $request->CODE_GUICHET;
        $organisme->NUM_COMPTE_BANQUE = $request->NUM_COMPTE_BANQUE;
        $organisme->RIB = $request->RIB;
        $organisme->IBAN = $request->IBAN;
        $organisme->BIC = $request->BIC;
        $organisme->save();
        for ( $i = 0; $i<10;$i++ ){
            if(isset($request['REF'.$i])){
                $certif = new CertificationsOrganismeModuleModel();
                $certif->ID_ORGANISME = $id;
                $certif->TITRE = $request['TITRE'.$i];
                $filename = md5(date('Y-m-d H:i:s')).'.'.$request['REF'.$i]->getClientOriginalExtension();
                Image::make($request['REF'.$i])
                    ->save(public_path('uploads/certifications/' . $filename));
                $certif->REF = $filename;
                $certif->save();
            }
        }
        return response()->json(['result'=>true,'id'=>$organisme->ID_ORGANISME]);


    }
    public function Delete($id){
        OrganismesModuleModel::destroy($id);
        return response()->json(true);
    }
}
