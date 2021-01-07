<?php

use Illuminate\Database\Seeder;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplier')->insert(array(
            [
                'supplier_nama'     => 'Agen Jatiwaringin',
                'supplier_alamat'   => 'Jl. Jatiwaringin Barat Daya No. 9C',
                'supplier_kontak'   => 'Bang Jate',
                'supplier_phone'   => '08992819281'
            ],
            [
                'supplier_nama'     => 'Agen Makmur',
                'supplier_alamat'   => 'Jl. Inspeksi Cakung Drain Timur No.1, Cakung Barat',
                'supplier_kontak'   => 'Si Makmur',
                'supplier_phone'   => '085281829181'
            ],
            [
                'supplier_nama'     => 'Toko Lestari Indah',
                'supplier_alamat'   => 'Jl. Kemanggisan Ilir XI No. 31C',
                'supplier_kontak'   => 'Lestari Sukma Putri',
                'supplier_phone'   => '08221928123'
            ],
            [
                'supplier_nama'     => 'Agen Lionwings Jakarta',
                'supplier_alamat'   => 'Jl. Meruya Barat XI No. 32F',
                'supplier_kontak'   => 'Sudino Uno',
                'supplier_phone'   => '08223315513'
            ],
            [
                'supplier_nama'     => 'Aneka Mie Instan',
                'supplier_alamat'   => 'Jl. Daan Mogot Timur No. 11A',
                'supplier_kontak'   => 'Kelvin',
                'supplier_phone'   => '08559192921'
            ]
        ));
    }
}
