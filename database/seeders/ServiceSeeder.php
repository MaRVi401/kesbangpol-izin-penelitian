<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('layanan')->truncate();
        Schema::enableForeignKeyConstraints();

        $services = [
            'Email E-Gov',
            'Subdomain',
            'Pembuatan App',
            'Pengaduan Sistem',
            'Pembuatan & Pengembangan apps',
            'Pengaduan Sistem Elektronik'
        ];

        foreach ($services as $nama) {
            DB::table('layanan')->insert([
                'uuid'             => (string) Str::uuid(),
                'nama'             => $nama,
                'status_arsip'     => false,
                'status_prioritas' => 'sedang',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]);
        }
    }
}