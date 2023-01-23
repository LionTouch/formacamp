<?php

namespace App\Modules\LieuxFormationModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LieuxFormationModuleModel extends Model
{
    protected $table = 'lieu_formation';
    protected $primaryKey = 'ID_LIEU_FORMATION';
    public $timestamps = false;
}
