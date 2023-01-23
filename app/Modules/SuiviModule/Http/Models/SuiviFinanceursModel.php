<?php

namespace App\Modules\SuiviModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SuiviFinanceursModel extends Model
{
    protected $table = 'suivi_financeurs';
    protected $primaryKey = 'ID_SUIVI_FINANCEURS';
    public $timestamps = false;
}
