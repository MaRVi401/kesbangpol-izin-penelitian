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

        $kabanUuid = (string) Str::uuid();         
        DB::table('users')->insert([             
            'uuid'       => $kabanUuid,             
            'nama'       => 'Nama Kaban Kesbangpol, M.Si.',             
            'username'   => 'kaban',             
            'password'   => Hash::make('password'),             
            'role'       => 'kaban',             
            'email'      => 'kaban@kesbangpol.local',             
            'no_wa'      => '081234567893',             
            'alamat'     => 'Ruang Kepala Badan',             
            'created_at' => now(),             
            'updated_at' => now(),         
        ]);         

        DB::table('kaban')->insert([             
            'uuid'                  => (string) Str::uuid(),             
            'users_id'              => $kabanUuid,             
            'nip'                   => '197001011995011001',             
            'nik'                   => '1234567890123452',             
            'jabatan_atasan'        => null,             
            'jabatan_penandatangan' => 'Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang',
            'pangkat_golongan'      => 'Pembina Utama Muda, (IV/c)',
            'created_at'            => now(),             
            'updated_at'            => now(),         
        ]);

        $dataKabid = [
            [
                'nama' => 'AVIEF SALAM RAKHMAT, ST',
                'username' => 'kabid_ideologi',
                'nip' => '198001012005011001',
                'jabatan_penandatangan' => 'Kepala Bidang Ideologi Wawasan Kebangsaan dan Karakter Bangsa',
                'pangkat_golongan' => 'Pembina, (IV/a)'
            ],
            [
                'nama' => 'Dr. Budi Santoso, M.Si.',
                'username' => 'kabid_kewaspadaan',
                'nip' => '197508172005011001',
                'jabatan_penandatangan' => 'Kepala Bidang Kewaspadaan Nasional dan Penanganan Konflik',
                'pangkat_golongan' => 'Pembina Tingkat I, (IV/b)'
            ],
            [
                'nama' => 'Dra. Siti Aminah, M.Pd.',
                'username' => 'kabid_politik',
                'nip' => '198003122008042002',
                'jabatan_penandatangan' => 'Kepala Bidang Politik Dalam Negeri dan Organisasi Kemasyarakatan',
                'pangkat_golongan' => 'Pembina, (IV/a)'
            ]
        ];

        foreach ($dataKabid as $index => $kabid) {
            $kabidUuid = (string) Str::uuid();         
            
            DB::table('users')->insert([             
                'uuid'       => $kabidUuid,             
                'nama'       => $kabid['nama'],             
                'username'   => $kabid['username'],             
                'password'   => Hash::make('password'),             
                'role'       => 'kabid',             
                'email'      => $kabid['username'] . '@kesbangpol.local',             
                'no_wa'      => '08123456789' . ($index + 4),             
                'alamat'     => 'Ruang Kabid ' . ($index + 1),             
                'created_at' => now(),             
                'updated_at' => now(),         
            ]);         

            DB::table('kabid')->insert([             
                'uuid'                  => (string) Str::uuid(),             
                'users_id'              => $kabidUuid,             
                'nip'                   => $kabid['nip'],             
                'nik'                   => '1234567890123452',             
                'jabatan_atasan'        => 'an. Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang',
                'jabatan_penandatangan' => $kabid['jabatan_penandatangan'],
                'pangkat_golongan'      => $kabid['pangkat_golongan'],
                'created_at'            => now(),             
                'updated_at'            => now(),         
            ]);
        }

        $this->command->info('Berhasil: UserSeeder telah dijalankan beserta data Kaban dan seluruh Kabid.');     
    } 
}