<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class QuestsTypesSessionsModulesModel extends Model
{
    protected $table = 'sessions_quest_types';
    protected $primaryKey = 'ID_TYPE';
    public $timestamps = false;
}
