<?php

namespace App\Modules\FinanceursExternesModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class FinanceursExternesModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'FinanceursExternesModule');
        $this->registerWebRoutes();
    }

    public function register()
    {
        View::addLocation(app_path().'/Modules/FinanceursExternesModule/Resources/views');
    }

    public function registerWebRoutes()
    {
        $prefixes = [''];
        foreach ($prefixes as $prefix) {
            Route::middleware('web')->prefix($prefix)->namespace('App\Modules\FinanceursExternesModule\Http\Controllers')->group(__DIR__  . '/../Routes/web.php');
        }
    }
}
