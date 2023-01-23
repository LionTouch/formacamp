<?php

namespace App\Modules\DashboardModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class DashboardModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'DashboardModule');
        $this->registerWebRoutes();
    }

    public function register()
    {
        View::addLocation(app_path().'/Modules/DashboardModule/Resources/views');
    }

    public function registerWebRoutes()
    {
        $prefixes = [''];
        foreach ($prefixes as $prefix) {
            Route::middleware('web')->prefix($prefix)->namespace('App\Modules\DashboardModule\Http\Controllers')->group(__DIR__  . '/../Routes/web.php');
        }
    }
}
