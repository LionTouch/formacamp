<?php

namespace App\Modules\StatutsModules\Http\Models;

use Illuminate\Database\Eloquent\Model;

class StatutsModulesModel extends Model
{
    protected $table = 'statuts';
    protected $primaryKey = 'ID_STATUT';
    public $timestamps = false;

}
