<?php

namespace App\Modules\ClientsModules\Http\Controllers;

use App\Modules\ClientsModules\Http\Models\ClientsTypeModulesModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
class ClientsTypeModulesController extends Controller
{
    public function List(){
        return ClientsTypeModulesModel::get();
    }
}
