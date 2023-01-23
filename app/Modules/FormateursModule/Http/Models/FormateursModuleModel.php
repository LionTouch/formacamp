<?php

namespace App\Modules\FormateursModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FormateursModuleModel extends Model
{
    protected $table = 'formateurs';
    protected $primaryKey = 'ID_FORMATEUR';
    public $timestamps = false;

    public function docs()
    {
        return $this->hasMany(DocsFormateursModuleModel::class,'ID_FORMATEUR','ID_FORMATEUR');
    }
}
