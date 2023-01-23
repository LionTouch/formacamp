<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectifsSessionsModuleModel extends Model
{
    protected $table = 'sessions_objectifs';
    protected $primaryKey = 'ID_OBJECTIF';
    public $timestamps = false;
}
