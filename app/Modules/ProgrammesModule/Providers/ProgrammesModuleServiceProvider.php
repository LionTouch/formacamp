<?php

namespace App\Modules\ProgrammesModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ProgrammesModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'ProgrammesModule');
        $this->registerWebRoutes();
    }

    public function register()
    {
        View::addLocation(app_path().'/Modules/ProgrammesModule/Resources/views');
    }

    public function registerWebRoutes()
    {
        $prefixes = [
            ''
        ];
        foreach ($prefixes as $prefix) {
            Route::middleware('web')->prefix($prefix)->namespace('App\Modules\ProgrammesModule\Http\Controllers')->group(__DIR__  . '/../Routes/web.php');
        }
    }
}
