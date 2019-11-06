<?php

use Illuminate\Database\Seeder;

use App\User;

class MainUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@way2web.com',
            'password' => bcrypt('admin'),
            'status' => 1,
        ]);
    }
}
