<?php

namespace App\Modules\CompteModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CompteAccesModulesModuleModel extends Model
{
    protected $table = 'acces_modules';
    protected $primaryKey = 'ID_MODULES';
    public $timestamps = false;

}
