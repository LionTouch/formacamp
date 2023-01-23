<?php

namespace App\Modules\CompteModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CompteAccesUsersModuleModel extends Model
{
    protected $table = 'acces_users';
    protected $primaryKey = ['ID_USER','ID_MODULES'];
    public $timestamps = false;
    public $incrementing = false;

}
