<?php
	return [
		"message" => "Welcome to your new package",


		/**
         * Prefix your url (The route would look something like this 'cms/users')
         *
         * @note add a '/' at the end of the prefix
         */
        'prefix' => 'cms/',


 		'classes' => [
 			'user_model' => 'App\User'
 			'password_reset_model' => 'Source\Entrance\Models\Password_reset'
 			'entrance_controller' => 'Source\Entrance\Http\Controllers\EntranceController'
 		]


	];