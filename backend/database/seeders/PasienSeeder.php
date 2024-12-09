<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patients')->insert([
            'nama' => Str::random(10),
            'tanggal_lahir' => '2023-09-08',
            'nik' => Str::random(10),
            'alamat' => Str::random(10),
            'gender' => 'M'
        ]);
    }
}
