<?php

namespace App\Modules\ProgrammesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PrerequisProgrammesModuleModel extends Model
{
    protected $table = 'programmes_prerequis';
    protected $primaryKey = 'ID_PREREQUIS';
    public $timestamps = false;
}
