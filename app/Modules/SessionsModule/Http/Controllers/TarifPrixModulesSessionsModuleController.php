<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\TarifPrixModulesSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TarifPrixModulesSessionsModuleController extends Controller
{
    public function List(){
        return TarifPrixModulesSessionsModuleModel::get();
    }
}
