<?php

namespace App\Modules\CompteModule\Http\Controllers;

use App\Modules\CompteModule\Http\Models\CompteAccesCategorieModuleModel;
use App\Modules\CompteModule\Http\Models\CompteAccesModuleModel;
use App\Modules\CompteModule\Http\Models\CompteAccesModulesModuleModel;
use App\Modules\CompteModule\Http\Models\CompteAccesUsersModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
class CompteAcceModulesModuleController extends Controller
{

    public function List(){
        return CompteAccesModulesModuleModel::get()->flatten();
    }

}
