<?php

namespace App\Modules\RepetitionsModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\RepetitionsModule\Http\Models\RepetitionsModuleModel;

class RepetitionsModuleController extends Controller
{
    public function List(){
        return RepetitionsModuleModel::get();
    }
}
