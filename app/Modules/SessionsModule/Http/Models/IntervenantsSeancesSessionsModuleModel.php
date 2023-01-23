<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class IntervenantsSeancesSessionsModuleModel extends Model
{
    protected $table = 'sessions_intervenants_seances';
    protected $primaryKey = ['ID_INTERVENANT','ID_SEANCE'];
    protected $fillable = ['ID_INTERVENANT','ID_SEANCE'];
    public $timestamps = false;
    public $incrementing = false;
}
