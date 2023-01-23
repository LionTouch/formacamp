<?php

namespace App\Modules\SallesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SallesModuleModel extends Model
{
    protected $table = 'salles';
    protected $primaryKey = 'ID_SALLE';
    public $timestamps = false;
}
