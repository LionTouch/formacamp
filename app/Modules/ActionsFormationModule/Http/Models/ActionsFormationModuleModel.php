<?php

namespace App\Modules\ActionsFormationModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ActionsFormationModuleModel extends Model
{
    protected $table = 'action_formation';
    protected $primaryKey = 'ID_ACTION';
    public $timestamps = false;
}
