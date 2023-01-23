<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\TypePrixModulesSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TypePrixModulesSessionsModuleController extends Controller
{
    public function List(){
        return TypePrixModulesSessionsModuleModel::get();
    }
}
