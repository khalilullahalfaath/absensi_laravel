<?php

namespace Database\Seeders;

use App\Models\User;
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
        $userData = [
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'no_presensi' => 'p123456',
            'password' => bcrypt('admin123'),
            'asal_instansi' => 'admin',
            'nama_unit_kerja' => 'admin',
            'jenis_kelamin' => 'male',
            'tanggal_lahir' => '2023-07-27'
        ];

        User::create($userData);
    }
}
