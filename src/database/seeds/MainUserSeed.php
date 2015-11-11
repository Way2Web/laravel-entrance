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
            'name' => 'thesource',
            'email' => 'cms@intothesource.com',
            'password' => bcrypt(''),
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);



    }
}
