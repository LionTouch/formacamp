<?php

namespace App\Modules\TypeVoieModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TypeVoieModuleModel extends Model
{
    protected $table = 'type_voie';
    protected $primaryKey = 'ID_TYPE_VOIE';
    public $timestamps = false;
}
