<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert(array(
            [
                'setting_nama' => 'Yuhumart',
                'setting_alamat' => 'Jl. Melati Putih, Kemanggisan, Palmerah, Jakarta Barat',
                'setting_phone' => '08992652281',
                'setting_image' => '1610051990.5ff77196aa775.png',
            ]
        ));
    }
}
