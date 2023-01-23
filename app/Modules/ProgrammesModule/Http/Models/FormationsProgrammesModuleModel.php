<?php

namespace App\Modules\ProgrammesModule\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class FormationsProgrammesModuleModel extends Model
{
    protected $table = 'programmes_formations';
    protected $primaryKey = 'ID_FORMATION';
    public $timestamps = false;

    public function sous_formations(){
        return $this->hasMany(SousFormationsProgrammesModuleModel::class,'ID_FORMATION','ID_FORMATION')
            ->select(
                '*',
                DB::raw('"1" as TYPE')
            )
            ->orderBy('INDX');

    }
}
