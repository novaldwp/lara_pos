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
                    'produk_jual' => 3000,
                    'produk_image' => '1610051776.5ff770c00de78.jpg',
                    'kategori_id' => 1
                ],
                [
                    'produk_kode' => 'PRDK0002',
                    'produk_nama' => 'Indomie Sedap',
                    'produk_beli' => 2150,
                    'produk_jual' => 3000,
                    'produk_image' => '1610051373.5ff76f2d5667f.jpg',
                    'kategori_id' => 1
                ],
                [
                    'produk_kode' => 'PRDK0003',
                    'produk_nama' => 'Odol Pepsodent',
                    'produk_beli' => 3200,
                    'produk_jual' => 4000,
                    'produk_image' => '1610051354.5ff76f1a6aa65.jpg',
                    'kategori_id' => 2
                ],
                [
                    'produk_kode' => 'PRDK0004',
                    'produk_nama' => 'Bodrex Extra',
                    'produk_beli' => 2700,
                    'produk_jual' => 4000,
                    'produk_image' => '1610051341.5ff76f0d9b0e1.jpg',
                    'kategori_id' => 3
                ],
                [
                    'produk_kode' => 'PRDK0005',
                    'produk_nama' => 'Sabun Lifeboy',
                    'produk_beli' => 2100,
                    'produk_jual' => 3000,
                    'produk_image' => '1610051222.5ff76e9677362.jpg',
                    'kategori_id' => 4
                ],
            )
        );
    }
}
