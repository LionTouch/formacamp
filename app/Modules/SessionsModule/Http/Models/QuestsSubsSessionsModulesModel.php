<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class QuestsSubsSessionsModulesModel extends Model
{
    protected $table = 'sessions_quest_subs';
    protected $primaryKey = 'ID_SUB_QUEST';
    public $timestamps = false;

    public function reponses()
    {
        return $this->hasMany(QuestsSubsReponsesSessionsModulesModel::class,'ID_SUB_QUEST','ID_SUB_QUEST');
    }
}
