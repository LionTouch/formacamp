<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SeancesModulesSessionsModel extends Model
{
    protected $table = 'sessions_modules_seances';
    protected $primaryKey = 'ID_SEANCE';
    public $timestamps = false;

    public function intervenants(){
        return $this->hasMany(IntervenantsSeancesSessionsModuleModel::class,'ID_SEANCE','ID_SEANCE');
    }
    public function attendees(){
        return $this->hasMany(IntervenantsSeancesSessionsModuleModel::class,'ID_SEANCE','ID_SEANCE')
            ->leftjoin('users','users.ID_USER','sessions_intervenants_seances.ID_INTERVENANT')
            ->leftJoin('organisme_admins',function ($join){
                $join->on('organisme_admins.ID_ADMIN','users.ID_USER')->where('users.TYPE','User');
            })->leftJoin('formateurs',function ($join){
                $join->on('formateurs.ID_FORMATEUR','users.ID_USER')->where('users.TYPE','FORMATEUR');
            })->distinct()
            ->select(
                'sessions_intervenants_seances.*',
                \DB::raw("
                 CASE
                       WHEN organisme_admins.NOM IS NOT NULL THEN CONCAT(organisme_admins.NOM,' ',organisme_admins.PRENOM)
                       WHEN formateurs.NOM IS NOT NULL THEN CONCAT(formateurs.NOM,' ',formateurs.PRENOM)
                 END
                 as NOM")
            );
    }
    public function emargement_intervenants(){
        return $this->hasMany(IntervenantsEmargementsSessionsModulesModel::class,'ID_SEANCE','ID_SEANCE');
    }

    public function emargement_apprenants(){
        return $this->hasMany(ApprenantsEmargementsSessionsModulesModel::class,'ID_SEANCE','ID_SEANCE');
    }
}
