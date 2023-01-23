<?php

namespace App\Modules\FormeJuridiqueModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\FormeJuridiqueModule\Http\Models\FormeJuridiqueModuleModel;

class FormeJuridiqueModuleController extends Controller
{
    public function List(){
        return FormeJuridiqueModuleModel::get();
    }


}
