<?php

namespace App\Modules\CivilitesModules\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\CivilitesModules\Http\Models\CivilitesModulesModel;

class CivilitesModulesController extends Controller
{
   public function List(){
       return CivilitesModulesModel::get();
   }

}
