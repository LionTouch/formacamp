<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ApprenantsSessionsModuleModel extends Model
{
    protected $table = 'sessions_apprenants';
    protected $primaryKey = ['ID_APPRENANT','ID_SESSION'];
    public $timestamps = false;
    public $incrementing = false;

    public function emargements(){
        return $this->hasMany(ApprenantsEmargementsSessionsModulesModel::class,'ID_APPRENANT','ID_APPRENANT')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_SEANCE','sessions_apprenants_emargements.ID_SEANCE')
            ->leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->select(
                'sessions_apprenants_emargements.*',
                'sessions_modules_seances.ID_MODULE',
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                'sessions_modules.ID_SESSION',
            )->groupBy('sessions_modules.ID_SESSION');
    }
}
