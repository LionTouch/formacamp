<?php

namespace App\Modules\ClientsModules\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ClientsContactsModulesModel extends Model
{
    protected $table = 'clients_contacts';
    protected $primaryKey = 'ID_CONTACT';
    public $timestamps = false;
}
