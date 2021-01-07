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
            'birthdate' => '08-06-1994',
            'photo'     => '1610051888.5ff77130d1924.png',
            'level'     => '1'
        ],
        [
            'name'      => 'Noval Dwi Putra',
            'username'  => 'petugas',
            'password'  => bcrypt('123'),
            'phone'     => '0899265228',
            'birthdate' => '17-11-1995',
            'photo'     => '1610051851.5ff7710be12b4.png',
            'level'     => '2'
        ]
        ));
    }
}
