<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SessionsModuleModel extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'ID_SESSION';
    public $timestamps = false;

    public function apprenants()
    {
        return $this->hasMany(ApprenantsSessionsModuleModel::class,'ID_SESSION','ID_SESSION')
            ->leftJoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT');
    }
    public function intervenants()
    {
        return $this->hasMany(IntervenantsSessionsModuleModel::class,'ID_SESSION','ID_SESSION')
            ->leftJoin('users','users.ID_USER','sessions_intervenants.ID_INTERVENANT')
            ->leftJoin('organisme_admins',function ($join){
                $join->on('organisme_admins.ID_ADMIN','users.ID_USER')->where('users.TYPE','User');
            })->leftJoin('formateurs',function ($join){
                $join->on('formateurs.ID_FORMATEUR','users.ID_USER')->where('users.TYPE','FORMATEUR');
            })->distinct()
            ->select(
                'sessions_intervenants.*',
                \DB::raw("
                 CASE
                       WHEN organisme_admins.NOM IS NOT NULL THEN organisme_admins.NOM
                       WHEN formateurs.NOM IS NOT NULL THEN formateurs.NOM
                 END
                 as NOM"),
                \DB::raw("
                 CASE
                       WHEN organisme_admins.PRENOM IS NOT NULL THEN organisme_admins.PRENOM
                       WHEN formateurs.PRENOM IS NOT NULL THEN formateurs.PRENOM
                 END
                 as PRENOM")
            );

    }

    public function seances()
    {
        return $this->hasManyThrough(
            SeancesModulesSessionsModel::class,
            ModulesSessionsModuleModel::class,
            'ID_SESSION',
            'ID_MODULE',
            'ID_SESSION',
            'ID_MODULE'
        )
            ->leftjoin('sessions_modules_types_seances','sessions_modules_types_seances.ID_TYPE_SEANCE','sessions_modules_seances.ID_TYPE_SEANCE')
            ->select(
                'sessions_modules_seances.*',
                \DB::raw('TIME_FORMAT(sessions_modules_seances.HD, "%H:%i") as HD'),
                \DB::raw('TIME_FORMAT(sessions_modules_seances.HF, "%H:%i") as HF'),
                \DB::raw('TIME_FORMAT(SEC_TO_TIME(sessions_modules_seances.DUREE*3600), "%H:%i") as DUREE_TIME'),
                'sessions_modules_types_seances.NOM as NOM_TYPE_SEANCE',
                \DB::raw('CONCAT( sessions_modules_seances.DATE,"T",DATE_FORMAT(HD,"%H:%i"),":00+00:00") as start'),
                \DB::raw('CONCAT( sessions_modules_seances.DATE,"T",DATE_FORMAT(HF,"%H:%i"),":00+00:00") as end')
            )->orderBy('DATE')->orderBy('HD');
    }

    public function seances_p()
    {
        return $this->hasManyThrough(
            SeancesModulesSessionsModel::class,
            ModulesSessionsModuleModel::class,
            'ID_SESSION',
            'ID_MODULE',
            'ID_SESSION',
            'ID_MODULE'
        );
    }
    public function modules(){
        return $this->hasMany(ModulesSessionsModuleModel::class,'ID_SESSION','ID_SESSION')->with('prix');
    }
}
