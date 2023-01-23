<?php

namespace App\Modules\TypeTarifModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\TypeTarifModule\Http\Models\TypeTarifModuleModel;

class TypeTarifModuleController extends Controller
{
    public function List(){
        return TypeTarifModuleModel::get();
    }
}
