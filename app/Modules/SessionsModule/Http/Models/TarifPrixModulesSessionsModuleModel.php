<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TarifPrixModulesSessionsModuleModel extends Model
{
    protected $table = 'sessions_modules_prix_tarif';
    protected $primaryKey = 'ID_TARIF';
    public $timestamps = false;
}
