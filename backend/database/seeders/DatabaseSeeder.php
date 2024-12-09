<?php

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('reservations')->insert([
            'perawatan' => 'Paru-paru',
            'tanggal' => Carbon::create(2024, 10, 10, 14, 30),
            'dokter' => 'Dr. Kevin Durant',
            'pasien_id' => 1
        ]);
    }
}
