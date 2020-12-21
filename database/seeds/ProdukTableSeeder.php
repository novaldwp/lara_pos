<?php

use Illuminate\Database\Seeder;

class ProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produk')->insert(array
            (
                [
                    'produk_kode' => 'PRDK0001',
                    'produk_nama' => 'Indomie Goreng',
                    'produk_beli' => 2200,
                    'produk_jual' => 2500,
                    'produk_image' => 'no_image.png',
                    'kategori_id' => 1
                ],
                [
                    'produk_kode' => 'PRDK0002',
                    'produk_nama' => 'Indomie Sedap',
                    'produk_beli' => 2150,
                    'produk_jual' => 2500,
                    'produk_image' => 'no_image.png',
                    'kategori_id' => 1
                ],
                [
                    'produk_kode' => 'PRDK0003',
                    'produk_nama' => 'Odol Pepsodent',
                    'produk_beli' => 2300,
                    'produk_jual' => 3000,
                    'produk_image' => 'no_image.png',
                    'kategori_id' => 2
                ],
            )
        );
    }
}
