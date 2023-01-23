<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PrixModulesSessionsModuleModel extends Model
{
    protected $table = 'sessions_modules_prix';
    protected $primaryKey = 'ID_PRIX';
    public $timestamps = false;
}
