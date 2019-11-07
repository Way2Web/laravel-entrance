<?php

namespace Way2Web\Entrance;

/*
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com> and Douwe de Haan <ddehaan@intothesource.com>
 */
use Illuminate\Support\ServiceProvider;

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
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/views'), 'entrance');
        $this->setupRoutes();
        $this->publishes([
                __DIR__ . '/config/entrance.php' => config_path('entrance.php'),
                __DIR__ . '/database/migrations' => database_path('migrations'),
                __DIR__ . '/database/seeds'      => database_path('seeds'),
        ]);
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function setupRoutes()
    {
        $routesFile = base_path() . '/routes/web.php';

        $currentRoutes = file_get_contents($routesFile);

        if (strstr($currentRoutes, 'ENTRANCE ROUTES') == false) {
            $token = '';
            $routes = "\n //ENTRANCE ROUTES \n//Prefix for the paths below.
Route::group(['prefix' => config('entrance.prefix')], function() {

    Route::get('login', ['as' => 'login.index', 'uses' => function () {
        return view('entrance::pages.login');
    }]);

    // POST - Logs user in
    Route::post('login', ['as' => 'postLogin', 'uses' => config('entrance.classes.entrance_controller').'@doLogin']);
    // GET - Logs user out
    Route::get('logout', ['as' => 'logout.index', 'uses' => config('entrance.classes.entrance_controller').'@doLogout']);

    // GET- Show succes page
    Route::get('resetSuccess', ['as' => 'reset.success', 'uses' => config('entrance.classes.entrance_controller').'@showResetSuccess']);
    Route::get('success', ['as' => 'success', 'uses' => function () {
        return view('entrance::pages.success');
    }]);

    // GET - Show the send reset e-mail page/form
    Route::get('reset-password', ['as' => 'reset.password', 'uses' => function () {
        return view('entrance::pages.resetpassword');
    }]);

    // POST - Send reset e-mail
    Route::post('sendReset', ['as' => 'sendReset', 'uses' => config('entrance.classes.entrance_controller').'@sendReset']);

    // GET - Show reset page/form
    Route::get('reset/{token}', ['as' => 'password_reset', 'middleware' => 'checktoken', 'uses' => function (\$token) {
        return view('entrance::pages.reset')->with(['token' => \$token]);
    }]);

    // POST - Reset Password
    Route::post('doReset', ['as' => 'doReset', 'uses' => config('entrance.classes.entrance_controller').'@doReset']);

    // GET - Show register form
    Route::get('register', ['as' => 'register', 'uses' => function() {
        return view('entrance::pages.register');
    }]);

    // POST - Register User
    Route::post('doRegister', ['as' => 'postRegister', 'uses' => config('entrance.classes.entrance_controller').'@doRegister']);

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
