<?php

namespace App\Modules\FormeJuridiqueModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FormeJuridiqueModuleModel extends Model
{
    protected $table = 'form_juridique';
    protected $primaryKey = 'ID_FORM_JURIDIQUE';
    public $timestamps = false;
}
