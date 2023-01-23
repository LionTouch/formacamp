<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TypesSeancesModulesSessionsModel extends Model
{
    protected $table = 'sessions_modules_types_seances';
    protected $primaryKey = 'ID_TYPE_SEANCE';
    public $timestamps = false;
}
