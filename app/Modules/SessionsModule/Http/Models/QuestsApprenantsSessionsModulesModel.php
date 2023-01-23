<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class QuestsApprenantsSessionsModulesModel extends Model
{
    protected $table = 'sessions_quest_apprenants';
    protected $primaryKey = ['ID_QUEST','ID_APPRENANT'];
    public $timestamps = false;
    public $incrementing = false;
}
