<?php

namespace App\Modules\FuseauxHoraireModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FuseauxHoraireModuleModel extends Model
{
    protected $table = 'fuseau_horaire';
    protected $primaryKey = 'ID_FUSEAU_HORAIRE';
    public $timestamps = false;
}
