<?php

namespace App\Modules\LanguesModules\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\LanguesModules\Http\Models\LanguesModulesModel;

class LanguesModulesController extends Controller
{
    public function List(){
        return LanguesModulesModel::get();
    }

}
