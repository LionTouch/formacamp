<?php

namespace App\Modules\CompteModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CompteAccesCategorieModuleModel extends Model
{
    protected $table = 'acces_categorie';
    protected $primaryKey = 'ID_CATEG';
    public $timestamps = false;

    public function modules()
    {
        return $this->hasMany(CompteAccesModulesModuleModel::class,'ID_CATEG','ID_CATEG');
    }
}
