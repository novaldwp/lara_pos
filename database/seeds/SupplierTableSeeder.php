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
                'supplier_nama'     => 'PT. Indofood Sukses Makmur',
                'supplier_alamat'   => 'Indofood Tower, Sudirman Plaza, Jl. Jend Sudirman No. Kav. 76-78',
                'supplier_kontak'   => 'Sudono Salim',
                'supplier_telpon'   => '08992819281',
                'supplier_website'  => 'http://www.indofood.com/'
            ],
            [
                'supplier_nama'     => 'PT. Lion Wings',
                'supplier_alamat'   => 'Jl. Inspeksi Cakung Drain Timur No.1, Cakung Barat',
                'supplier_kontak'   => 'Bapak Singa',
                'supplier_telpon'   => '085281829181',
                'supplier_website'  => 'http://www.lionwings.com/'
            ],
            [
                'supplier_nama'     => 'PT. Unilever Indonesia',
                'supplier_alamat'   => 'Menara Duta Lt. 5, Jl. HR Rasuna Said, Kuningan',
                'supplier_kontak'   => 'Lever Brothers',
                'supplier_telpon'   => '08221928123',
                'supplier_website'  => 'http://www.unilever.co.id/'
            ]
        ));
    }
}
