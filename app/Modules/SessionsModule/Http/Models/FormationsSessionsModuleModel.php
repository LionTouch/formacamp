<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FormationsSessionsModuleModel extends Model
{
    protected $table = 'sessions_formations';
    protected $primaryKey = 'ID_FORMATION';
    public $timestamps = false;

    public function sous_formations(){
        return $this->hasMany(SousFormationsSessionsModuleModel::class,'ID_FORMATION','ID_FORMATION')
            ->select(
                '*',
                DB::raw('"1" as TYPE')
            )
            ->orderBy('INDX');

    }
}
