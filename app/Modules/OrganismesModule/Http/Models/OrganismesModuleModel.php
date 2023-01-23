<?php

namespace App\Modules\OrganismesModule\Http\Models;

use App\Modules\CertificationsModule\Http\Models\CertificationsOrganismeModuleModel;
use Illuminate\Database\Eloquent\Model;

class OrganismesModuleModel extends Model
{
    protected $table = 'organismes';
    protected $primaryKey = 'ID_ORGANISME';
    public $timestamps = false;
    public function certifications()
    {
        return $this->hasMany(CertificationsOrganismeModuleModel::class,'ID_ORGANISME','ID_ORGANISME');
    }
}
