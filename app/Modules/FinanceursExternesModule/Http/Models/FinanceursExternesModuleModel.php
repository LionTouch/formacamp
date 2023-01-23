<?php

namespace App\Modules\FinanceursExternesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceursExternesModuleModel extends Model
{
    protected $table = 'financeurs';
    protected $primaryKey = 'ID_FINANCEUR';
    public $timestamps = false;
}
