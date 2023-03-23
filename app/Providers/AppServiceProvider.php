<?php

namespace App\Providers;

use App\View\Components\FileInput;
use App\View\Components\Select2;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Bpocallaghan\Generators\GeneratorsServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production') || $this->app->environment('development')) {
            URL::forceScheme('https');
        }
        Blade::component('select2', Select2::class);
        Blade::component('fileinput', FileInput::class);

    }
}
