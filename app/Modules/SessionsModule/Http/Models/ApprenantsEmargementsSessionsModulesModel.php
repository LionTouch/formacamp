<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ApprenantsEmargementsSessionsModulesModel extends Model
{
    protected $table = 'sessions_apprenants_emargements';
    protected $primaryKey = ['ID_APPRENANT','ID_SEANCE'];
    public $timestamps = false;
    public $incrementing = false;
}
