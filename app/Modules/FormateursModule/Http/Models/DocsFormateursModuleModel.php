<?php

namespace App\Modules\FormateursModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DocsFormateursModuleModel extends Model
{
    protected $table = 'documents_formateurs';
    protected $primaryKey = 'ID_DOC';
    public $timestamps = false;

}
