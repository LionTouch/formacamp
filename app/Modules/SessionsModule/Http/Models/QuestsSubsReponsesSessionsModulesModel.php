<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class QuestsSubsReponsesSessionsModulesModel extends Model
{
    protected $table = 'sessions_quest_subs_reponses';
    protected $primaryKey = 'ID_REPONSE';
    public $timestamps = false;
}
