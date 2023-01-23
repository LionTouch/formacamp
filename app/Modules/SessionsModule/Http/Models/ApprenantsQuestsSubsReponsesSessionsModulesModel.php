<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ApprenantsQuestsSubsReponsesSessionsModulesModel extends Model
{
    protected $table = 'sessions_apprenants_sub_quest_reponses';
    protected $primaryKey = ['ID_APPRENANT','ID_SUB_QUEST'];
    public $timestamps = false;
    public $incrementing = false;
}
