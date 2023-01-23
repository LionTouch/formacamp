<?php

namespace App\Modules\FormateursModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class StatutsFormateursModuleModel extends Model
{
    protected $table = 'statuts_formateurs';
    protected $primaryKey = 'ID_STATUT';
    public $timestamps = false;
}
