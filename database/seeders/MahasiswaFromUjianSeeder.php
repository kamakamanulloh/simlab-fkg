<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class MahasiswaFromUjianSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data dari database ujian
        $mahasiswas = DB::connection('ujian')
            ->table('mahasiswa')
            ->get(['nama', 'nim']);

        foreach ($mahasiswas as $mhs) {

            // Hindari duplicate berdasarkan username (nim)
            User::updateOrCreate(
                ['username' => $mhs->nim],
                [
                    'name'     => $mhs->nama,
                    'password' => $mhs->nim, // akan di-hash otomatis
                    'role'     => 'Mahasiswa',
                ]
            );
        }
    }
}