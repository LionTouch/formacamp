<?php

namespace App\Modules\ProgrammesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectifsProgrammesModuleModel extends Model
{
    protected $table = 'programmes_objectifs';
    protected $primaryKey = 'ID_OBJECTIF';
    public $timestamps = false;
}
