<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\TypesSeancesModulesSessionsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TypesSeancesModulesSessionsController extends Controller
{
    public function List(){
        return TypesSeancesModulesSessionsModel::get();
    }
}
