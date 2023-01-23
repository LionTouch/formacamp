<?php

namespace App\Modules\SuperUser\Http\Controllers;

use App\Modules\DirecteurModule\Http\Controllers\DirecteurModuleController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\SuperUser\Http\Models\SuperUserModel;

class SuperUserController extends Controller
{
    public function index(){
        return view('super');
    }

    public function ListOrganismes(){
       return DirecteurModuleController::leftjoin('user','user.ID_USER','admins.ID_ADMIN')->get();
    }
}
