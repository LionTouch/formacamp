<?php

namespace App\Modules\MessagerieModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MessagerieSignatureModel extends Model
{
    protected $table = 'signature_message';
    protected $primaryKey = 'ID_SIGNATURE';
    public $timestamps = false;
}
