<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilsApprenantsSessionsModuleModel extends Model
{
    protected $table = 'sessions_profils_apprenants';
    protected $primaryKey = 'ID_PROFIL';
    public $timestamps = false;
}
