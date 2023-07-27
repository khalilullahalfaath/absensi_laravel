<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'role'=> 0,
            'password' => Hash::make('haloIniAdalahPassword123456'),
            'asal_instansi' => 'admin',
            'nama_unit_kerja' => 'admin',
            'jenis_kelamin' => 'male',
            'tanggal_lahir' => '2023-07-27'
        ]);

    }
}
