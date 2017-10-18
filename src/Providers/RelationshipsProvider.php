<?php

namespace Acacha\Relationships\Providers;

use Illuminate\Support\ServiceProvider;
use Acacha\Relationships\Relationships;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;

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

        $this->registerEloquentFactoriesFrom(RELATIONSHIPS_PATH . '/database/factories');
    }

    protected function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $router = app('router');

            $router->group(['namespace' => 'Acacha\Relationships\Http\Controllers'], function () {
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

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }

}