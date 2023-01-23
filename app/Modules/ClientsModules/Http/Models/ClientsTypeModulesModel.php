<?php

namespace App\Modules\ClientsModules\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ClientsTypeModulesModel extends Model
{
    protected $table = 'clients_type';
    protected $primaryKey = 'ID_TYPE_CLIENT';
    public $timestamps = false;
}
