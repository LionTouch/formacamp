<?php

namespace App\Modules\ProgrammesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SousFormationsProgrammesModuleModel extends Model
{
    protected $table = 'programmes_sub_formations';
    protected $primaryKey = 'ID_SUB_FORMATION';
    public $timestamps = false;

}
