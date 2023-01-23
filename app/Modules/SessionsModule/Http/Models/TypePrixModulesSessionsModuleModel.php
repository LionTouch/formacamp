<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TypePrixModulesSessionsModuleModel extends Model
{
    protected $table = 'sessions_type_prix_modules';
    protected $primaryKey = 'ID_TYPE_PRIX';
    public $timestamps = false;
}
