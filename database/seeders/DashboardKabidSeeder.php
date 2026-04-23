<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tiket;
use App\Models\Layanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DashboardKabidSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat beberapa Operator (Pastikan UUID disertakan karena model menggunakan HasUuids)
        $operators = [];
        $names = ['Agus Operator', 'Budi Service', 'Siti Support', 'Dewi Kominfo'];

        foreach ($names as $name) {
            $operators[] = User::updateOrCreate(
                ['username' => Str::slug($name)],
                [
                    'uuid' => (string) Str::uuid(),
                    'nama' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'operator',
                    'email' => Str::slug($name) . '@subang.go.id',
                ]
            );
        }

        // 2. Ambil semua layanan
        $layananIds = Layanan::pluck('uuid');

        if ($layananIds->isEmpty()) {
            $this->command->warn('Tabel layanan kosong. Jalankan LayananSeeder terlebih dahulu!');
            return;
        }

        // 3. Buat Data Tiket Acak sesuai struktur migrasi terbaru
        $statuses = ['diajukan', 'ditangani', 'selesai', 'ditolak'];

        for ($i = 0; $i < 50; $i++) {
            $status = $statuses[array_rand($statuses)];

            // Petugas diisi jika status bukan 'diajukan'
            $petugasId = ($status !== 'diajukan')
                ? $operators[array_rand($operators)]->uuid
                : null;

            Tiket::create([
                'uuid' => (string) Str::uuid(),
                'no_tiket' => 'TK-' . strtoupper(Str::random(8)),
                'users_id' => User::where('role', 'pengguna_asn')->first()?->uuid ?? User::first()->uuid,
                'layanan_id' => $layananIds->random(),
                'petugas_id' => $petugasId,
                'status' => $status,
                'deskripsi' => 'Data simulasi tiket ke-' . $i . ' untuk monitoring dashboard Kabid.',
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('Berhasil! 50 data simulasi tiket telah ditambahkan.');
    }
}
