<?php

namespace App\Modules\StatutsModules\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\StatutsModules\Http\Models\StatutsModulesModel;

class StatutsModulesController extends Controller
{
    public function List(){
        return StatutsModulesModel::get();
    }

}
