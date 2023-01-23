<?php

namespace App\Modules\FormateursModule\Http\Controllers;

use App\Modules\StatutsModules\Http\Models\StatutsModulesModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StatutsFormateursModuleController extends Controller
{
    public function List(){
        return StatutsModulesModel::get();
    }

    public function Delete($id){
        StatutsModulesModel::destroy($id);
        return response()->json(true);
    }
}
