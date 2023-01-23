<?php

namespace App\Modules\TypeFinanceurModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\TypeFinanceurModule\Http\Models\TypeFinanceurModuleModel;

class TypeFinanceurModuleController extends Controller
{
    public function List(){
        return TypeFinanceurModuleModel::get();
    }
}
