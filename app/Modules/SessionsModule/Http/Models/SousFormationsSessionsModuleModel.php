<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SousFormationsSessionsModuleModel extends Model
{
    protected $table = 'sessions_sub_formations';
    protected $primaryKey = 'ID_SUB_FORMATION';
    public $timestamps = false;

}
