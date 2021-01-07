<?php

use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert(array(
            [
                'kategori_nama' => 'Mie Instan'
            ],
            [
                'kategori_nama' => 'Pasta Gigi'
            ],
            [
                'kategori_nama' => 'Obat'
            ],
            [
                'kategori_nama' => 'Sabun'
            ],
            [
                'kategori_nama' => 'Chiki'
            ]
        ));
    }
}
