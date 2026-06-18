<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        $adminUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'       => $adminUuid,
            'nama'       => 'Jack',
            'username'   => 'superadmin',
            'password'   => Hash::make('12345678'),
            'role'       => 'super_admin',
            'email'      => 'jack@kesbangpol.local',
            'no_wa'      => '081234567890',
            'alamat'     => 'Indramayu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('super_admin')->insert([
            'uuid'       => (string) Str::uuid(),
            'users_id'   => $adminUuid,
            'nip'        => '199001012024011001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Mahasiswa
        $mhsUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'       => $mhsUuid,
            'nama'       => 'Mahasiswa Polindra',
            'username'   => 'mahasiswa',
            'password'   => Hash::make('password'),
            'role'       => 'mahasiswa',
            'email'      => 'mahasiswa@mail.com',
            'no_wa'      => '081234567891',
            'alamat'     => 'Jl. Lohbener Lama',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mahasiswa')->insert([
            'uuid'        => (string) Str::uuid(),
            'users_id'    => $mhsUuid,
            'nim'         => '2203001',
            'status_akun' => 'aktif',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // 3. Operator
        $opUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'       => $opUuid,
            'nama'       => 'Operator Layanan',
            'username'   => 'operator',
            'password'   => Hash::make('password'),
            'role'       => 'operator',
            'email'      => 'operator@mail.com',
            'no_wa'      => '081234567892',
            'alamat'     => 'Ruang Operator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('operator')->insert([
            'uuid'       => (string) Str::uuid(),
            'users_id'   => $opUuid,
            'nip'        => '198501012010011001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Kabid
        $kabidUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'       => $kabidUuid,
            'nama'       => 'Kepala Bidang',
            'username'   => 'kabid',
            'password'   => Hash::make('password'),
            'role'       => 'kabid',
            'email'      => 'kabid@mail.com',
            'no_wa'      => '081234567893',
            'alamat'     => 'Ruang Kabid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kabid')->insert([
            'uuid'       => (string) Str::uuid(),
            'users_id'   => $kabidUuid,
            'nip'        => '197501012000011001',
            'nik'        => '3212000000000001', // Penambahan kolom NIK agar tidak error Not Null Violation
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Berhasil: UserSeeder telah dijalankan sesuai skema migration terbaru.');
    }
}