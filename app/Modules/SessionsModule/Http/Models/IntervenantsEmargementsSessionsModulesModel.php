<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class IntervenantsEmargementsSessionsModulesModel extends Model
{
    protected $table = 'sessions_intervenants_emargements';
    protected $primaryKey = ['ID_INTERVENANT','ID_SEANCE'];
    public $timestamps = false;
    public $incrementing = false;
}
