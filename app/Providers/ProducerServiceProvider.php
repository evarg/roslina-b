<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Dupa;

class ProducerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(Dupa::class, function($app){
        //     return new Dupa();
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
