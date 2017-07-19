<?php
namespace Lloricode\LaravelHtmlTable;

use Illuminate\Support\ServiceProvider;

class LaravelHtmlTableProvider extends ServiceProvider
{
        /**
        * Bootstrap the application services.
        *
        * @return void
        */
        public function boot()
        { 
                //
        }

        /**
        * Register the application services.
        *
        * @return void
        */
        public function register()
        {
                $this->app->singleton('lloricodelaravelhtmltable', function ($app) {
 			return new LaravelHtmlTableGenerator;
 		});
        }
}
