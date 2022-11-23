<?php

namespace Database\Seeders;

use App\Models\Pupuk;
use Illuminate\Database\Seeder;

class PupukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = date('Y-m-d');
        $data = [
            [
                'nama'          => 'Pupuk Organik Bokashi',
                'keterangan'    => 'Keterangan 1',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Pupuk Fosfor (Phospat)',
                'keterangan'    => 'Keterangan 2',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Pupuk Kalium',
                'keterangan'    => 'Keterangan 3',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Pupuk Mikro Plant Activator',
                'keterangan'    => 'Keterangan 4',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'ZPT (Zat Pengatur Tumbuh)',
                'keterangan'    => 'Keterangan 5',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
        ];

        Pupuk::insert($data);
    }
}
