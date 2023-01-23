<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ModulesModalitesSessionsModuleModel extends Model
{
    protected $table = 'sessions_modules_modalites';
    protected $primaryKey = 'ID_MODALITE';
    public $timestamps = false;
}
