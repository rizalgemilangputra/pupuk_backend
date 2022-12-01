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
                'nama'          => 'Organik Bokashi',
                'keterangan'    => 'Keterangan 1',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Fosfor (Phospat)',
                'keterangan'    => 'Keterangan 2',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Kalium',
                'keterangan'    => 'Keterangan 3',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Mikro Plant Activator',
                'keterangan'    => 'Keterangan 4',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Zat Pengatur Tumbuh',
                'keterangan'    => 'Keterangan 5',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
        ];

        Pupuk::insert($data);
    }
}
