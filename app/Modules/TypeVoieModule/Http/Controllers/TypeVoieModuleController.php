<?php

namespace App\Modules\TypeVoieModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\TypeVoieModule\Http\Models\TypeVoieModuleModel;

class TypeVoieModuleController extends Controller
{
    public function List(){
        return TypeVoieModuleModel::get();
    }
}
