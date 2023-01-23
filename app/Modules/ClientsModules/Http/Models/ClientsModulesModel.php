<?php

namespace App\Modules\ClientsModules\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ClientsModulesModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'ID_CLIENT';
    public $timestamps = false;
}
