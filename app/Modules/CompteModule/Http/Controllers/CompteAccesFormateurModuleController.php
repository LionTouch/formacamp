<?php

namespace App\Modules\CompteModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CompteAccesFormateurModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }
    public function List(){
        return CompteAccesUsersModuleModel::where('ID_USER',Auth::id())->get()->except('password');
    }
    public function Get($id){
        return CompteAccesUsersModuleModel::where('ID_USER',$id)->get()->pluck('ID_MODULES');

    }
    public function Save(Request $request){
        try {
            $modules = json_decode($request->modules);
            foreach($modules as $module){
                $module_acces = New CompteAccesUsersModuleModel();
                $module_acces->ID_MODULES = $module;
                $module_acces->ID_USER = $request->ID_USER;
                $module_acces->save();
            }

        }
        catch (\Exception $e){
            return response()->json(false);
        }
        return response()->json(true);

    }
    public function Update(Request $request, $id){
        try {

            $modules = json_decode($request->modules);

            CompteAccesUsersModuleModel::where('ID_USER',$id)->delete();
            foreach($modules as $module){
                $module_acces = New CompteAccesUsersModuleModel();
                $module_acces->ID_MODULES = $module;
                $module_acces->ID_USER = $id;
                $module_acces->save();
            }



        }
        catch (\Exception $e){
            return response()->json(false);
        }
        return response()->json(true);
    }
    public function Delete($id){
        CompteAccesModuleModel::destroy($id);
        CompteAccesUsersModuleModel::where('ID_ACCES',$id)->delete();
        return response()->json(true);
    }
    public function test(){
        $acces = CompteAccesUsersModuleModel::leftjoin('acces_modules','acces_modules.ID_MODULES','acces_users.ID_MODULES')
            ->where('ID_USER',Auth::id())
            ->get()
            ->pluck('TITRE');
        return response()->json($acces);
    }
}
