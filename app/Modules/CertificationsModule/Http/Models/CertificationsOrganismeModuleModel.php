<?php

namespace App\Modules\CertificationsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationsOrganismeModuleModel extends Model
{
    protected $table = 'certifications_organismes';
    protected $primaryKey = 'ID_CERTIF';
    public $timestamps = false;

}
