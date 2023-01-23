<?php

namespace App\Modules\StagiairesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class StagiairesModuleModel extends Model
{
    protected $table = 'stagiaires';
    protected $primaryKey = 'ID_STAGIAIRE';
    public $timestamps = false;
}
