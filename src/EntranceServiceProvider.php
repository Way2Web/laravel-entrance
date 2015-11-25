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

        $this->loadViewsFrom(realpath(__DIR__.'/views'), 'entrance');
        $this->setupRoutes();
        // this  for conig
                $this->publishes([
                        __DIR__.'/config/entrance.php' => config_path('entrance.php'),
                        __DIR__.'/database/migrations' => database_path('migrations'),
                        __DIR__.'/database/seeds' => database_path('seeds'),
                        //__DIR__.'/models' => app_path(),
                        //__DIR__.'/views/emails' => base_path('resources/views/intothesource/entrance/emails'),
                        //__DIR__.'/views/pages' => base_path('resources/views/intothesource/entrance/pages'),
                        //__DIR__.'/Http/Controllers' => app_path('Http/Controllers/Intothesource/Entrance'),

                ]);



    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes()
    {
        $routesFile = app_path().'/Http/routes.php';

        $currentRoutes = file_get_contents($routesFile);

        if(strstr($currentRoutes,"ENTRANCE ROUTES") == false){
            $token = '';
            $routes = "\n //ENTRANCE ROUTES \n//Prefix for the paths below.
Route::group(['prefix' => config('entrance.prefix')], function() {

    Route::get('login', ['as' => 'login.index', 'uses' => function () {
        return view('entrance::pages.login');
    }]);

    // POST - Logs user in
    Route::post('login', ['as' => 'postLogin', 'uses' => config('entrance.classes.entrance_controller').'EntranceController@doLogin']);
    // GET - Logs user out
    Route::get('logout', ['as' => 'logout.index', 'uses' => config('entrance.classes.entrance_controller').'EntranceController@doLogout']);

    // GET- Show succes page
    Route::get('resetSuccess', ['as' => 'reset.success', 'uses' => config('entrance.classes.entrance_controller').'EntranceController@showResetSuccess']);
    Route::get('success', function () {
        return view('entrance::pages.success');
    });

    // GET - Show the send reset e-mail page/form
    Route::get('reset-password', ['as' => 'reset.password', 'uses' => function () {
        return view('entrance::pages.resetpassword');
    }]);

    // POST - Send reset e-mail
    Route::post('sendReset', ['as' => 'sendReset', 'uses' => config('entrance.classes.entrance_controller').'EntranceController@sendReset']);

    // GET - Show reset page/form
    Route::get('reset/{token}', ['as' => 'password_reset', 'middleware' => 'checktoken', 'uses' => function ($token) {
        return view('entrance::pages.reset')->with(['token' => $token]);
    }]);

    //POST - Reset Password
    Route::post('doReset', ['as' => 'doReset', 'uses' => config('entrance.classes.entrance_controller').'EntranceController@doReset']);


    //Authentication group - Check if user is logged in
    Route::group(['middleware' => 'checklogin'], function() {

    });
});
        \n";


        file_put_contents($routesFile, $routes, FILE_APPEND | LOCK_EX);
        }

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
