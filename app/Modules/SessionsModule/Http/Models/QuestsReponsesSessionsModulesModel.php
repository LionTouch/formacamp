<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class QuestsReponsesSessionsModulesModel extends Model
{
    protected $table = 'sessions_quest_reponses';
    protected $primaryKey = 'ID_QUEST';
    public $timestamps = false;
}
