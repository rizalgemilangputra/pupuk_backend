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
                'nama'          => 'Pupuk 1',
                'keterangan'    => 'Keterangan 1',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Pupuk 2',
                'keterangan'    => 'Keterangan 2',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Pupuk 3',
                'keterangan'    => 'Keterangan 3',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Pupuk 4',
                'keterangan'    => 'Keterangan 4',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            [
                'nama'          => 'Pupuk 5',
                'keterangan'    => 'Keterangan 5',
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
        ];

        Pupuk::insert($data);
    }
}
