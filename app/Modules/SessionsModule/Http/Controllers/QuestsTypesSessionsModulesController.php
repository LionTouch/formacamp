<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\QuestsTypesSessionsModulesModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class QuestsTypesSessionsModulesController extends Controller
{
    public function List(){
        return QuestsTypesSessionsModulesModel::get();
    }

}
