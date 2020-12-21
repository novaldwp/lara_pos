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
                'member_nama'       => 'Jaenudin',
                'member_phone'      => '085218292958',
                'member_alamat'     => 'Jl. Kebon Sirih'
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
        ));
    }
}
