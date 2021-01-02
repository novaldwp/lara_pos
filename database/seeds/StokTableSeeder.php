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
                'stok_jumlah'   => '25'
            ],
            [
                'produk_id'     => '2',
                'stok_jumlah'   => '20'
            ],
            [
                'produk_id'     => '3',
                'stok_jumlah'   => '15'
            ]
        ));
    }
}
