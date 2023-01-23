<?php

namespace App\Modules\CompteModule\Http\Controllers;

use App\Modules\AdminsModule\Http\Models\AdminsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\CompteModule\Http\Models\CompteModuleModel;
use DB;
use Auth;
class CompteModuleController extends Controller
{

    public function index()
    {
        return view('app');
    }
    public function Get($id){
        $user =  DB::table('admins')->leftJoin('users','admins.ID_ADMIN','users.ID_USER')
            ->leftjoin('repetitions','repetitions.ID_REPETITION','admins.ID_REPETITION')
            ->leftjoin('type_voie','type_voie.ID_TYPE_VOIE','admins.ID_TYPE_VOIE')
            ->leftjoin('fuseau_horaire','fuseau_horaire.ID_FUSEAU_HORAIRE','admins.ID_FUSEAU_HORAIRE')
            ->leftjoin('form_juridique','form_juridique.ID_FORM_JURIDIQUE','admins.ID_FORM_JURIDIQUE')
            ->leftjoin('monnaie','monnaie.ID_MONNAIE','admins.ID_MONNAIE')
            ->select(
                'admins.*',
                'users.*',
                'repetitions.TITRE as TITRE_REPETITION',
                'type_voie.TITRE as TITRE_TYPE_VOIE',
                'fuseau_horaire.TITRE as TITRE_FUSEAU_HORAIRE',
                'form_juridique.TITRE as TITRE_FORME_JURIDIQUE',
                'monnaie.TITRE as TITRE_MONNAIE',
            )
//            ->with('certifications')
            ->where('ID_ADMIN',Auth::id())->get();
//        $user->makeHidden('password');
        return $user;
    }

}
