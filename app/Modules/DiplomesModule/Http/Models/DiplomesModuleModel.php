<?php

namespace App\Modules\DiplomesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DiplomesModuleModel extends Model
{
    protected $table = 'diplomes';
    protected $primaryKey = 'ID_DIPLOME';
    public $timestamps = false;
}
