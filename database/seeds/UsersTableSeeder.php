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
            'name'      => 'Administrator',
            'username'  => 'admin',
            'password'  => bcrypt('123'),
            'phone'     =>  '08992652281',
            'birthdate' => '1995-11-17',
            'photo'     => '',
            'level'     => 1
        ],
        [
            'name'      => 'Noval Dwi Putra',
            'username'  => 'opalski',
            'password'  => bcrypt('123'),
            'phone'     =>  '08992652281',
            'birthdate' => '1995-11-17',
            'photo'     => '',
            'level'     => 2
        ],
        [
            'name'      => 'Devitha Octaviani',
            'username'  => 'devidiot',
            'password'  => bcrypt('password'),
            'phone'     => '082211702979',
            'birthdate' => '1996-10-24',
            'photo'     => '',
            'level'     => 2
        ]
        ));
    }
}
