<?php

namespace IntoTheSource\Entrance;

/**
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com> and Douwe de Haan <ddehaan@intothesource.com>
 */
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class EntranceServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Perform post-registration booting of services.
     * 
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../views'), 'entrance');
        $this->setupRoutes($this->app->router);
        // this  for conig
                $this->publishes([
                        __DIR__.'/config/entrance.php' => config_path('entrance.php'),
                        __DIR__.'/migrations' => database_path('migrations'),
                        __DIR__.'/models' => app_path(),
                        __DIR__.'/views/emails' => base_path('resources/views/intothesource/entrance/emails'),
                        __DIR__.'/views/pages' => base_path('resources/views/intothesource/entrance/pages'),
                        __DIR__.'/Http/Controllers' => app_path('Http/Controllers/Intothesource/Entrance'),

                ]);
    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'App\Http\Controllers\IntoTheSource\Entrance'], function ($router) {
            require __DIR__.'/Http/routes.php';
        });
    }
    /**
     * Registers the config file during publishing.
     * 
     * @return void 
     */
    public function register()
    {
        $this->registerEntrance();
        config([
                'config/entrance.php',
        ]);
    }
    /**
     * Registers the packages.
     * 
     * @return Entrance app
     */
    private function registerEntrance()
    {
        $this->app->bind('entrance', function ($app) {
            return new Entrance($app);
        });
    }
}
