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

        DB::table('layanan')->insert([
            'uuid'             => (string) Str::uuid(),
            'nama'             => 'Surat Permohonan Izin Penelitian',
            'status_arsip'     => false,
            'status_prioritas' => 'sedang',
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now(),
        ]);

        $this->command->info('Berhasil: ServiceSeeder telah menambahkan layanan tunggal.');
    }
}