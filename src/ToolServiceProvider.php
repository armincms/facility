<?php

namespace Armincms\Facility;
 
use Illuminate\Support\ServiceProvider;   

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');   
        \Gate::policy(Facility::class, Policies\FacilityPolicy::class);
    }  

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
