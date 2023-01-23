<?php

namespace App\Modules\MonnaieModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\MonnaieModule\Http\Models\MonnaieModuleModel;

class MonnaieModuleController extends Controller
{
    public function List(){
        return MonnaieModuleModel::get();
    }
}
