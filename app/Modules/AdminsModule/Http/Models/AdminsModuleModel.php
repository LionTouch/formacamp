<?php

namespace App\Modules\AdminsModule\Http\Models;

use App\Modules\CertificationsModule\Http\Models\CertificationsModuleModel;
use Illuminate\Database\Eloquent\Model;

class AdminsModuleModel extends Model
{
    protected $table = 'organisme_admins';
    protected $primaryKey = 'ID_ADMIN';
    public $timestamps = false;
    protected $fillable = [
        'ID_ADMIN',
    ];

    public function certifications()
    {
        return $this->hasMany(CertificationsModuleModel::class,'ID_USER','ID_ADMIN');
    }
}
