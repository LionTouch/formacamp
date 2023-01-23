<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ApprenantsQuestsReponsesSessionsModulesModel extends Model
{
    protected $table = 'sessions_apprenants_quest_reponses';
    protected $primaryKey = ['ID_APPRENANT','ID_QUEST'];
    public $timestamps = false;
    public $incrementing = false;
}
