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
                'nama' => 'AVIEF SALAM RAKHMAT, ST',
                'nip' => '198001012005011001',
                'jabatan_atasan' => 'an. Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang',
                'jabatan_penandatangan' => 'Kepala Bidang Ideologi Wawasan Kebangsaan dan Karakter Bangsa',
                'pangkat_golongan' => 'Pembina, (IV/a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'nama' => 'Dr. Budi Santoso, M.Si.',
                'nip' => '197508172005011001',
                'jabatan_atasan' => 'an. Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang',
                'jabatan_penandatangan' => 'Kepala Bidang Kewaspadaan Nasional dan Penanganan Konflik',
                'pangkat_golongan' => 'Pembina Tingkat I, (IV/b)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'nama' => 'Dra. Siti Aminah, M.Pd.',
                'nip' => '198003122008042002',
                'jabatan_atasan' => 'an. Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang',
                'jabatan_penandatangan' => 'Kepala Bidang Politik Dalam Negeri dan Organisasi Kemasyarakatan',
                'pangkat_golongan' => 'Pembina, (IV/a)',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}