<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenandatanganSuratSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penandatangan_surat')->insert([
            [
                'uuid' => Str::uuid()->toString(),
                'nama' => 'Dr. Budi Santoso, M.Si.',
                'nip' => '197508172005011001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'nama' => 'Dra. Siti Aminah, M.Pd.',
                'nip' => '198003122008042002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'nama' => 'Ir. Wahyu Pratama, M.T.',
                'nip' => '198211052010121003',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}