<?php

namespace App\Modules\ProgrammesModule\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ProgrammesModuleModel extends Model
{
    protected $table = 'programmes';
    protected $primaryKey = 'ID_PROGRAMME';
    public $timestamps = false;

    public function objectifs()
    {
        return $this->hasMany(ObjectifsProgrammesModuleModel::class,'ID_PROGRAMME','ID_PROGRAMME')->orderBy('INDX');
    }
    public function prerequis()
    {
        return $this->hasMany(PrerequisProgrammesModuleModel::class,'ID_PROGRAMME','ID_PROGRAMME')->orderBy('INDX');
    }
    public function potentiels()
    {
        return $this->hasMany(PotentielsProgrammesModuleModel::class,'ID_PROGRAMME','ID_PROGRAMME');
    }
    public function formations()
    {
        return $this->hasMany(FormationsProgrammesModuleModel::class,'ID_PROGRAMME','ID_PROGRAMME')
            ->with('sous_formations');
    }
}
