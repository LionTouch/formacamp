<?php

namespace App\Modules\SuiviModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SuiviModuleModel extends Model
{
    protected $table = 'suivi_commercial';
    protected $primaryKey = 'ID_SUIVI';
    public $timestamps = false;

    public function financeurs()
    {
        return $this->hasMany(SuiviFinanceursModel::class,'ID_SUIVI','ID_SUIVI');
    }
}
