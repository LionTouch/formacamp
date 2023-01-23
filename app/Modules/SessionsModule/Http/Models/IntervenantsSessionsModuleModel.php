<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class IntervenantsSessionsModuleModel extends Model
{
    protected $table = 'sessions_intervenants';
    protected $primaryKey = ['ID_INTERVENANT','ID_SESSION'];
    public $timestamps = false;
    public $incrementing = false;

    public function modules()
    {
        return $this->hasMany(ModulesSessionsModuleModel::class,'ID_SESSION','ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->select(
                'sessions_modules.*',
                DB::raw('MIN(sessions_modules_seances.DATE) as START'),
                DB::raw('MAX(sessions_modules_seances.DATE) as END'),
            )
            ->orderBy('START')
            ->groupBy('sessions_modules.ID_MODULE');
    }

    public function seances(){
        return $this->hasManyThrough(
            SeancesModulesSessionsModel::class,
            ModulesSessionsModuleModel::class,
            'ID_SESSION',
            'ID_MODULE',
            'ID_SESSION',
            'ID_MODULE',
        )
//            ->leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->leftjoin('sessions_modules_types_seances','sessions_modules_types_seances.ID_TYPE_SEANCE','sessions_modules_seances.ID_TYPE_SEANCE')
            ->leftjoin('salles','salles.ID_SALLE','sessions_modules_seances.ID_SALLE')
            ->select(
                'sessions_modules_seances.*',
//                'sessions_intervenants_seances.*',
                'sessions_modules.NOM as NOM_MODULE',
                'sessions_modules_types_seances.NOM as NOM_TYPE_SEANCE',
                'salles.NOM as NOM_SALLE',
                DB::raw('sessions_modules_seances.DATE as INDX')
            )
            ->orderByRaw("ID_MODULE,DATE, HD")
            ;
    }
}
