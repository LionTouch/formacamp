<?php

namespace App\Modules\OrganismesModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class OrganismesModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'OrganismesModule');
        $this->registerWebRoutes();
    }

    public function register()
    {
        View::addLocation(app_path().'/Modules/OrganismesModule/Resources/views');
    }

    public function registerWebRoutes()
    {
        $prefixes = [''];
        foreach ($prefixes as $prefix) {
            Route::middleware('web')->prefix($prefix)->namespace('App\Modules\OrganismesModule\Http\Controllers')->group(__DIR__  . '/../Routes/web.php');
        }
    }
}
