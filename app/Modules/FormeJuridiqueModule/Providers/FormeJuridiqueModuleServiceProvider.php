<?php

namespace App\Modules\FormeJuridiqueModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class FormeJuridiqueModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'FormeJuridiqueModule');
        $this->registerWebRoutes();
    }

    public function register()
    {
        View::addLocation(app_path().'/Modules/FormeJuridiqueModule/Resources/views');
    }

    public function registerWebRoutes()
    {
        $prefixes = [''];
        foreach ($prefixes as $prefix) {
            Route::middleware('web')->prefix($prefix)->namespace('App\Modules\FormeJuridiqueModule\Http\Controllers')->group(__DIR__  . '/../Routes/web.php');
        }
    }
}
