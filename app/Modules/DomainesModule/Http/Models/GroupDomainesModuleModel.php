<?php

namespace App\Modules\DomainesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class GroupDomainesModuleModel extends Model
{
    protected $table = 'domaines_group';
    protected $primaryKey = 'ID_GROUP';
    public $timestamps = false;

    public function domaines()
    {
        return $this->hasMany(DomainesModuleModel::class,'ID_GROUP','ID_GROUP');
    }
}
