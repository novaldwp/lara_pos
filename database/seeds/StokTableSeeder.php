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
                'produk_id'     => '1',
                'stok_jumlah'   => '40'
            ],
            [
                'produk_id'     => '2',
                'stok_jumlah'   => '45'
            ],
            [
                'produk_id'     => '3',
                'stok_jumlah'   => '38'
            ],
            [
                'produk_id'     => '4',
                'stok_jumlah'   => '28'
            ],
            [
                'produk_id'     => '5',
                'stok_jumlah'   => '37'
            ]
        ));
    }
}
