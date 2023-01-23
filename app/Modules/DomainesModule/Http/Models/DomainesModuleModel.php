<?php

namespace App\Modules\DomainesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DomainesModuleModel extends Model
{
    protected $table = 'domaines';
    protected $primaryKey = 'ID_DOMAINE';
    public $timestamps = false;
}
