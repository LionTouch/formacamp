<?php

namespace App\Modules\CertificationsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationsModuleModel extends Model
{
    protected $table = 'certifications';
    protected $primaryKey = 'ID_CERTIF';
    public $timestamps = false;


}
