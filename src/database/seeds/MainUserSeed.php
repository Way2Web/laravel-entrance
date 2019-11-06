<?php

use Illuminate\Database\Seeder;

class MainUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'admin',
            'email'    => 'admin@way2web.com',
            'password' => bcrypt('admin'),
            'status'   => 1,
        ]);
    }
}
