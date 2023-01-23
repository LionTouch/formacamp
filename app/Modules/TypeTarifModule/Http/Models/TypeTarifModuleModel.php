<?php

namespace App\Modules\TypeTarifModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTarifModuleModel extends Model
{
    protected $table = 'type_tarif';
    protected $primaryKey = 'ID_TYPE_TARIF';
    public $timestamps = false;
}
