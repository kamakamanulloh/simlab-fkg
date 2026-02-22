<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // ==== ADMIN SISTEM ====
            [
                'username' => 'admin',
                'name'     => 'Administrator SIM-Lab',
                'nip ' => '213245',
                'email'    => 'admin@simlab.local',
                'password' => 'Admin123!',

                'role'     => 'Admin',
            ],

            // ==== KEPALA LAB ====
            [
                'username' => 'kepalalab',
                'name'     => 'Prof. Dr. Ahmad Santoso',
                 'nip ' => '878678',
                'email'    => 'kepalalab@simlab.local',
               'password' => 'KepalaLab123!',
                'role'     => 'Kepala Lab',
            ],

            // ==== KOORDINATOR PRAKTIKUM ====
            [
                'username' => 'koordinator',
                 'nip ' => '0976845',
                'name'     => 'Drg. Siti Rahmawati',
                'email'    => 'koordinator@simlab.local',
                'password' => 'Koordinator123!',
                'role'     => 'Koordinator Praktikum',
            ],

            // ==== TEKNISI LAB ====
            [
                'username' => 'teknisi',
                 'nip ' => '468909',
                'name'     => 'Budi Santoso',
                'email'    => 'teknisi@simlab.local',
              'password' => 'Teknisi123!',
                'role'     => 'Teknisi',
            ],

            // ==== DOSEN ====
            [
                'username' => 'dosen',
                 'nip ' => '354678',
                'name'     => 'Drg. Lina Kurnia',
                'email'    => 'dosen@simlab.local',
                'password' => 'Dosen123!',
                'role'     => 'Dosen',
            ],

            // ==== MAHASISWA ====
            [
                'username' => 'mahasiswa',
                 'nip ' => '0789968',
                'name'     => 'Muhammad Rizky',
                'email'    => 'mahasiswa@simlab.local',
               'password' => 'Mahasiswa123!',
                'role'     => 'Mahasiswa',
            ],

            // ==== TIM MUTU ====
            [
                'username' => 'timmutu',
                 'nip ' => '436346',
                'name'     => 'Dewi Lestari',
                'email'    => 'timmutu@simlab.local',
              'password' => 'TimMutu123!',
                'role'     => 'Tim Mutu',
            ],
        ];

        // Insert satu per satu
        foreach ($users as $u) {
            User::updateOrCreate(
                ['username' => $u['username']],  // kondisi pencarian
                $u
            );
        }
    }
}
