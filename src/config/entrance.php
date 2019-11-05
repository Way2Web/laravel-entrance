<?php
	return [
		"message" => "Welcome to your new package",


		/**
         * Prefix your url (The route would look something like this 'cms/users')
         *
         * @note add a '/' at the end of the prefix
         */
        'prefix' => 'cms/',
        
        /**
         * Users need to be activated for logging in
         */
        'activated' => FALSE,
        
        /**
         * Set the minimal length of the passwords
         */
        'password_length' => 5,

 		'classes' => [
 			'user_model' => 'App\User',
 			'password_reset_model' => '\Way2Web\Entrance\Models\Password_reset',
 			'entrance_controller' => '\Way2Web\Entrance\Http\Controllers\EntranceController'
 		],

 		'mail' => [
 			'password_reset' => 'entrance::emails.passwordreset'
 		]


	];