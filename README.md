# Entrance
Full entrance package, including login and password reset.

##### Change the from e-mail adres:
Change Global adres inside config/mail.php to the adres you want to send from.


##### ServiceProvider
Add the following provider to config/app.php: <br>
```bash
IntoTheSource\Entrance\EntranceServiceProvider::class,
```

##### Middleware
Add the following middleware routes to app/Http/Kernel.php: <br>
```bash
'checktoken' => \IntoTheSource\Entrance\Http\Middleware\CheckToken::class,
'checklogin' => \IntoTheSource\Entrance\Http\Middleware\CheckLogin::class,
```

##### Publish Files
Run the following command: <br>
```bash
php artisan vendor:publish
```

##### Authenticate Routes
```bash
Route::group(['middleware' => 'checklogin'], function() {
    <Your routes>
});
```
##### Change successful login redirect
put the following into your routes: <br>
```bash
Route::get('entrance/success', function () {
    return view('<desired path>');
});
```
##### Insert user
put the following seeds to database/seeds/DatabaseSeeder.php in the run() function<br>
```bash
$this->call(MainUserSeed::class);
```
Run
```bash
artisan db:seed
```
