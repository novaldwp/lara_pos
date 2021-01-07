<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('member')->insert(array(
            [
                'member_kode'       => '1911001',
                'member_nama'       => 'Umum',
                'member_phone'      => '',
                'member_alamat'     => ''
            ],
            [
                'member_kode'       => '1911002',
                'member_nama'       => 'Safarrudin',
                'member_phone'      => '085727172844',
                'member_alamat'     => 'Jl. Kebon Kacang'
            ],
            [
                'member_kode'       => '1911003',
                'member_nama'       => 'Sumiyati',
                'member_phone'      => '082218284894',
                'member_alamat'     => 'Jl. Ketapang Sirih'
            ],
            [
                'member_kode'       => '1911004',
                'member_nama'       => 'Jainuri',
                'member_phone'      => '086631284894',
                'member_alamat'     => 'Jl. Kedondong Utara No. 9C'
            ],
            [
                'member_kode'       => '1911005',
                'member_nama'       => 'Priyatno',
                'member_phone'      => '082215512333',
                'member_alamat'     => 'Jl. Rambutan Selatan No. 3C'
            ],
        ));
    }
}
