<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil dari database ujian
        $users = DB::connection('ujian')
            ->table('users')
            ->where('role_id', 1)
            ->where('blok', 3)
            ->get(['name', 'username', 'email']);

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['username' => $user->username], // supaya tidak duplicate
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make('123456789'),
                    'role' => 'Dosen',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}