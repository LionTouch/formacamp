<?php

namespace App\Modules\MonnaieModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MonnaieModuleModel extends Model
{
    protected $table = 'monnaie';
    protected $primaryKey = 'ID_MONNAIE';
    public $timestamps = false;
}
