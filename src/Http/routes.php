<?php


//Prefix for the paths below.
Route::group(['prefix' => config('entrance.prefix')], function() {
    // GET - Show login page
    Route::get('login', ['as' => 'login.index', 'uses' => 'EntranceController@showLogin']);
    // POST - Logs user in
    Route::post('login', ['as' => 'postLogin', 'uses' => 'EntranceController@doLogin']);
    // GET - Logs user out
    Route::get('logout', ['as' => 'logout.index', 'uses' => 'EntranceController@doLogout']);

    // GET- Show succes page
    Route::get('resetSuccess', ['as' => 'reset.success', 'uses' => 'EntranceController@showResetSuccess']);
    Route::get('success', function () {
        return view('intothesource/entrance/pages/success');
    });

    // GET - Show the send reset e-mail page/form
    Route::get('reset-password', ['as' => 'reset.password', 'uses' => function () {
        return view('intothesource/entrance/pages/resetpassword');
    }]);

    // POST - Send reset e-mail
    Route::post('sendReset', ['as' => 'sendReset', 'uses' => 'EntranceController@sendReset']);

    // GET - Show reset page/form
    Route::get('reset/{token}', ['as' => 'password_reset', 'middleware' => 'checktoken', 'uses' => function ($token) {
        return view('intothesource.entrance.pages.reset')->with(['token' => $token]);
    }]);

    //POST - Reset Password
    Route::post('doReset', ['as' => 'doReset', 'uses' => 'EntranceController@doReset']);


    //Authentication group - Check if user is logged in
    Route::group(['middleware' => 'checklogin'], function() {

    });
});


