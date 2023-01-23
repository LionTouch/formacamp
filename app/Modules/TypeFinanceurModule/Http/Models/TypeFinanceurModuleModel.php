<?php

namespace App\Modules\TypeFinanceurModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TypeFinanceurModuleModel extends Model
{
    protected $table = 'type_financeur';
    protected $primaryKey = 'ID_TYPE_FINANCEUR';
    public $timestamps = false;
}
