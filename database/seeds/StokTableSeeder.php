<?php

use Illuminate\Database\Seeder;

class StokTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stok')->insert(array(
            [
                'stok_jumlah' => 20,
                'stok_status' => 'minim',
                'produk_id' => 1
            ],
            [
                'stok_jumlah' => 40,
                'stok_status' => 'aman',
                'produk_id' => 4
            ],
            [
                'stok_jumlah' => 0,
                'stok_status' => 'habis',
                'produk_id' => 3
            ]


        ));
    }
}
