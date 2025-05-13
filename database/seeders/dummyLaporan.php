<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class dummyLaporan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laporan')->insert([
            [
                'id_laporan' => 'LP-001',
                'user_id' => 1,
                'nama' => 'Laporan A',
                'deskripsi' => 'Deskripsi laporan A',
                'tanggal' => Carbon::now()->toDateString(),
                'status' => 'selesai',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_laporan' => 'LP-002',
                'user_id' => 2,
                'nama' => 'Laporan B',
                'deskripsi' => 'Deskripsi laporan B',
                'tanggal' => Carbon::now()->toDateString(),
                'status' => 'proses',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
