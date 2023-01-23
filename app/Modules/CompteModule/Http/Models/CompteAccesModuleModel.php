<?php

namespace App\Modules\CompteModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CompteAccesModuleModel extends Model
{
    protected $table = 'acces_users';
    protected $primaryKey = 'ID_USER';
    public $timestamps = false;
    public function modules()
    {
        return $this->hasMany(CompteAccesUsersModuleModel::class,'ID_ACCES','ID_ACCES');
    }
}
