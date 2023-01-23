<?php

namespace App\Modules\DashboardModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\DashboardModule\Http\Models\DashboardModuleModel;
use Auth;
class DashboardModuleController extends Controller
{

    public function index()
    {
        if(Auth::guard('web')->check()){
            return view('app');
        }else{
            return view('super');
        }

    }
}
