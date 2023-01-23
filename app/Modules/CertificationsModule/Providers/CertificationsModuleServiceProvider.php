<?php

namespace App\Modules\CertificationsModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CertificationsModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'CertificationsModule');
        $this->registerWebRoutes();
    }

    public function register()
    {
        View::addLocation(app_path().'/Modules/CertificationsModule/Resources/views');
    }

    public function registerWebRoutes()
    {
        $prefixes = [''];
        foreach ($prefixes as $prefix) {
            Route::middleware('web')->prefix($prefix)->namespace('App\Modules\CertificationsModule\Http\Controllers')->group(__DIR__  . '/../Routes/web.php');
        }
    }
}
