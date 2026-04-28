<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        
        // Truncate tabel sesuai migrasi terbaru
        DB::table('users')->truncate();
        DB::table('super_admin')->truncate();
        DB::table('mahasiswa')->truncate();
        DB::table('kabid')->truncate();
        DB::table('operator')->truncate();
        
        Schema::enableForeignKeyConstraints();

        // 1. Super Admin
        $adminUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'     => $adminUuid,
            'nama'     => 'Jack',
            'username' => 'superadmin',
            'password' => Hash::make('12345678'),
            'role'     => 'super_admin',
            'email'    => 'jack@simdokum.local',
            'no_wa'    => '081234567890',
            'alamat'   => 'Kosan Sukabumi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('super_admin')->insert([
            'uuid'     => (string) Str::uuid(),
            'users_id' => $adminUuid,
            'nip'      => '199001012024011001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Mahasiswa
        $mhsUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'     => $mhsUuid,
            'nama'     => 'Mahasiswa Polindra',
            'username' => 'mahasiswa',
            'password' => Hash::make('password'),
            'role'     => 'mahasiswa',
            'email'    => 'mahasiswa@mail.com',
            'no_wa'    => '081234567891',
            'alamat'   => 'Jl. Lohbener Lama',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mahasiswa')->insert([
            'uuid'     => (string) Str::uuid(),
            'users_id' => $mhsUuid,
            'nim'      => '2203001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Operator
        $opUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'     => $opUuid,
            'nama'     => 'Operator Layanan',
            'username' => 'operator',
            'password' => Hash::make('password'),
            'role'     => 'operator',
            'email'    => 'operator@mail.com',
            'no_wa'    => '081234567892',
            'alamat'   => 'Ruang Operator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('operator')->insert([
            'uuid'     => (string) Str::uuid(),
            'users_id' => $opUuid,
            'nip'      => '198501012010011001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Kabid
        $kabidUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid'     => $kabidUuid,
            'nama'     => 'Kepala Bidang',
            'username' => 'kabid',
            'password' => Hash::make('password'),
            'role'     => 'kabid',
            'email'    => 'kabid@mail.com',
            'no_wa'    => '081234567893',
            'alamat'   => 'Ruang Kabid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kabid')->insert([
            'uuid'     => (string) Str::uuid(),
            'users_id' => $kabidUuid,
            'nip'      => '197501012000011001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Berhasil: UserSeeder telah dijalankan dengan skema role baru.');
    }
}