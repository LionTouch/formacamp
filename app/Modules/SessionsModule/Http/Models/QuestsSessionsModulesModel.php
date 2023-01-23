<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class QuestsSessionsModulesModel extends Model
{
    protected $table = 'sessions_quest';
    protected $primaryKey = 'ID_QUEST';
    public $timestamps = false;
    public function sub_quests()
    {
        return $this->hasMany(QuestsSubsSessionsModulesModel::class,'ID_QUEST','ID_QUEST')
            ->leftjoin(
                'sessions_apprenants_sub_quest_reponses',
                'sessions_apprenants_sub_quest_reponses.ID_SUB_QUEST',
                'sessions_quest_subs.ID_SUB_QUEST'
            )->select(
                'sessions_quest_subs.*',
                'sessions_apprenants_sub_quest_reponses.ID_APPRENANT',
                'sessions_apprenants_sub_quest_reponses.REPONSE'
            )
            ->with('reponses');
    }
    public function reponses()
    {
        return $this->hasMany(QuestsReponsesSessionsModulesModel::class,'ID_QUEST','ID_QUEST');
    }
}
