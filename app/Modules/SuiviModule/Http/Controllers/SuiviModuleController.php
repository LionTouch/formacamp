<?php

namespace App\Modules\SuiviModule\Http\Controllers;

use App\Modules\SuiviModule\Http\Models\SuiviFinanceursModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\SuiviModule\Http\Models\SuiviModuleModel;

class SuiviModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }
    public function List(){
        return SuiviModuleModel::leftjoin('clients','clients.ID_CLIENT','suivi_commercial.ID_CLIENT')
            ->leftjoin('formateurs','formateurs.ID_FORMATEUR','suivi_commercial.ID_FORMATEUR')
            ->with('financeurs')
            ->select(
                'suivi_commercial.*',
                'clients.NOM as NOM_CLIENT',
                'formateurs.NOM as NOM_FORMATEUR',
            )
            ->get();
    }
    public function Get($id){
        return SuiviModuleModel::with('financeurs')->findOrFail($id);
    }

    public function Save(Request $request){
        $suivi = New SuiviModuleModel();

        $suivi->ID_SUIVI = $request->ID_SUIVI;
        $suivi->TITRE = $request->TITRE;
        if(isset($request->ID_CLIENT)){
            $suivi->ID_CLIENT = $request->ID_CLIENT;
        }
        if(isset($request->ID_FORMATEUR)){
            $suivi->ID_FORMATEUR = $request->ID_FORMATEUR;
        }
        $suivi->SITUATION = $request->SITUATION;
        $suivi->DISPOSITIF = $request->DISPOSITIF;
        $suivi->LIGNE_PRODUIT = $request->LIGNE_PRODUIT;
        $suivi->LIGNE_STAGIAIRE = $request->LIGNE_STAGIAIRE;
        if($request->SITUATION == 1){
            $suivi->NBR_STAGIAIRE = $request->NBR_STAGIAIRE;
        }else{
            $suivi->NBR_STAGIAIRE = NULL;
        }

        $suivi->save();

        $suivi_f = new SuiviFinanceursModel();
        $suivi_f->ID_SUIVI_FINANCEURS = $request->ID_SUIVI_FINANCEURS;
        $suivi_f->ID_SUIVI = $suivi->ID_SUIVI;
        $suivi_f->ID_FINANCEUR = $request->ID_FINANCEUR;
        $suivi_f->MONTANT = $request->MONTANT;
        $suivi_f->SUBROGATION = $request->SUBROGATION;
        $suivi_f->REF_ACCORD = $request->REF_ACCORD;
        $suivi_f->DEV_ENTREPRISE = $request->DEV_ENTREPRISE;
        $suivi_f->COMPTE_FORMATION = $request->COMPTE_FORMATION;
        $suivi_f->CPF_TRANSITION = $request->CPF_TRANSITION;
        $suivi_f->CONGE_INDIV = $request->CONGE_INDIV;
        $suivi_f->CONTRAT_PROF = $request->CONTRAT_PROF;
        $suivi_f->PERIODE_PROF = $request->PERIODE_PROF;
        if($request->SUBROGATION == 1){
            $suivi_f->CODE_CPF = $request->CODE_CPF;
            $suivi_f->DUREE = $request->DUREE;
        }else{
            $suivi_f->CODE_CPF = NULL;
            $suivi_f->DUREE = NULL;
        }


        $suivi_f->save();

        return response()->json(true);
    }

    public function Update(Request $request,$id){
        $suivi = SuiviModuleModel::with('financeurs')->findOrFail($id);


        $suivi->TITRE = $request->TITRE;
        if(isset($request->ID_CLIENT)){
            $suivi->ID_CLIENT = $request->ID_CLIENT;
        }
        if(isset($request->ID_FORMATEUR)){
            $suivi->ID_FORMATEUR = $request->ID_FORMATEUR;
        }
        $suivi->SITUATION = $request->SITUATION;
        $suivi->DISPOSITIF = $request->DISPOSITIF;
        $suivi->LIGNE_PRODUIT = $request->LIGNE_PRODUIT;
        $suivi->LIGNE_STAGIAIRE = $request->LIGNE_STAGIAIRE;
        $suivi->NBR_STAGIAIRE = $request->NBR_STAGIAIRE;
        $suivi->save();
        if($suivi->financeurs[0]->ID_FINANCEUR != $request->ID_FINANCEUR){
            SuiviFinanceursModel::where('ID_SUIVI',$id)->delete();
            $suivi_f = new SuiviFinanceursModel();

        }else{
            $suivi_f = SuiviFinanceursModel::findOrFail($suivi->financeurs[0]->ID_SUIVI_FINANCEURS);
        }
        $suivi_f->ID_FINANCEUR = $request->ID_FINANCEUR;
        $suivi_f->MONTANT = $request->MONTANT;
        $suivi_f->SUBROGATION = $request->SUBROGATION;
        $suivi_f->REF_ACCORD = $request->REF_ACCORD;
        $suivi_f->DEV_ENTREPRISE = $request->DEV_ENTREPRISE;
        $suivi_f->COMPTE_FORMATION = $request->COMPTE_FORMATION;
        $suivi_f->CPF_TRANSITION = $request->CPF_TRANSITION;
        $suivi_f->CONGE_INDIV = $request->CONGE_INDIV;
        $suivi_f->CONTRAT_PROF = $request->CONTRAT_PROF;
        $suivi_f->PERIODE_PROF = $request->PERIODE_PROF;
        $suivi_f->CODE_CPF = $request->CODE_CPF;
        $suivi_f->DUREE = $request->DUREE;
        $suivi_f->save();


        return response()->json(true);
    }

    public function Delete($id){
        SuiviModuleModel::destroy($id);
        SuiviFinanceursModel::where('ID_SUIVI',$id)->delete();
        return response()->json(true);
    }
}
