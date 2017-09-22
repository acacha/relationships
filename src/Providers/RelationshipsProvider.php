<?php

namespace Acacha\Relationships\Providers;

use Illuminate\Support\ServiceProvider;
use Acacha\Relationships\Relationships;

/**
 * Class RelationshipsProvider.
 *
 * @package Acacha\Relationships\Providers
 */

class RelationshipsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->defineRoutes();

//        //Publish
//        $this->publishViews();
//
//        $this->publishSeeds();

        //Loading
        $this->loadMigrations();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (!defined('RELATIONSHIPS_PATH')) {
            define('RELATIONSHIPS_PATH', realpath(__DIR__.'/../../'));
        }

        $this->app->bind('Relationships', function () {
            return new Relationships();
        });
    }

    protected function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $router = app('router');

            $router->group(['namespace' => 'Acacha\Scool\Staff\Http\Controllers'], function () {
                require __DIR__.'/../Http/routes.php';
            });
        }
    }

    /**
     * Load migrations.
     */
    private function loadMigrations()
    {
        $this->loadMigrationsFrom(RELATIONSHIPS_PATH . '/database/migrations');
    }
}