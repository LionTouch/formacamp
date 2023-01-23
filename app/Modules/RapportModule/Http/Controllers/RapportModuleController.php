<?php

namespace App\Modules\RapportModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\RapportModule\Http\Models\RapportModuleModel;

class RapportModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }
}
