<?php

namespace App\Modules\ProgrammesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PotentielsProgrammesModuleModel extends Model
{
    protected $table = 'programmes_potentiels';
    protected $primaryKey = 'ID_POTENTIEL';
    public $timestamps = false;
}
