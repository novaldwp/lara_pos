<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array([
            'name' => 'Noval Dwi Putra',
            'username' => 'opalski',
            'password' => bcrypt('password'),
            'photo' => 'no_image.png',
            'level' => 1
        ],
        [
            'name' => 'Devitha Octaviani',
            'username' => 'devidiot',
            'password' => bcrypt('password'),
            'photo' => 'no_image.png',
            'level' => 2
        ]
        ));
    }
}
