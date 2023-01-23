<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ModulesModalitesSessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ModulesModalitesSessionsModuleController extends Controller
{
    public function List(){
        return ModulesModalitesSessionsModuleModel::get();
    }
}
