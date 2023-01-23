<?php

namespace App\Modules\RepetitionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RepetitionsModuleModel extends Model
{
    protected $table = 'repetitions';
    protected $primaryKey = 'ID_REPETITION';
    public $timestamps = false;
}
