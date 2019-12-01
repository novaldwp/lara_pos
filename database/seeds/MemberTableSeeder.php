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

        DB::table('members')->insert(array(
            [
                'member_kode'       => '1911001',
                'member_nama'       => 'Jaenudin',
                'member_alamat'     => 'Jl. Kebon Sirih',
                'member_kelamin'    => '1',
                'member_hp'         => '085218292958'
            ],
            [
                'member_kode'       => '1911002',
                'member_nama'       => 'Safarrudin',
                'member_alamat'     => 'Jl. Kebon Kacang',
                'member_kelamin'    => '1',
                'member_hp'         => '085727172844'
            ],
            [
                'member_kode'       => '1911003',
                'member_nama'       => 'Sumiyati',
                'member_alamat'     => 'Jl. Ketapang Sirih',
                'member_kelamin'    => '2',
                'member_hp'         => '082218284894'
            ],
        ));
    }
}
