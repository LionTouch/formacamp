<?php

namespace App\Modules\DirecteurModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DirecteurModuleModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'ID_ADMIN';
    public $timestamps = false;
    protected $fillable = [
        'ID_ADMIN',
    ];
}
