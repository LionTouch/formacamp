<?php

namespace App\Modules\FuseauxHoraireModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\FuseauxHoraireModule\Http\Models\FuseauxHoraireModuleModel;

class FuseauxHoraireModuleController extends Controller
{
    public function List(){
        return FuseauxHoraireModuleModel::get();
    }
}
