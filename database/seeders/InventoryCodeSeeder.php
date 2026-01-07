<?php

namespace Database\Seeders;

use App\Models\InventoryCode;
use Illuminate\Database\Seeder;

class InventoryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventory_codes = [
            [
                'code' => 'A01',
                'name' => 'Tanah',
            ],
            [
                'code' => 'A02',
                'name' => 'Bangunan',
            ],
            [
                'code' => 'B01',
                'name' => 'Meja Siswa',
            ],
            [
                'code' => 'B02',
                'name' => 'Kursi Siswa',
            ],
            [
                'code' => 'B03',
                'name' => 'Meja Guru, Pegawai, Perpustakaan, Lab',
            ],
            [
                'code' => 'B04',
                'name' => 'Kursi Plastik Guru, Pegawai, Perpustakaan, Lab',
            ],
            [
                'code' => 'B05',
                'name' => 'Papan Tulis',
            ],
            [
                'code' => 'B06',
                'name' => 'Kursi Putar',
            ],
            [
                'code' => 'B07',
                'name' => 'Lemari, Filling Cabinet, Katalog',
            ],
            [
                'code' => 'B08',
                'name' => 'Locker dan Rak Buku',
            ],
            [
                'code' => 'B09',
                'name' => 'Brangkas',
            ],
            [
                'code' => 'B10',
                'name' => 'Papan Statistik',
            ],
            [
                'code' => 'B11',
                'name' => 'Jam Dinding',
            ],
            [
                'code' => 'B12',
                'name' => 'Gambar dan Hiasan Dinding',
            ],
            [
                'code' => 'B13',
                'name' => 'Mading',
            ],
            [
                'code' => 'C01',
                'name' => 'Komputer (CPU)',
            ],
            [
                'code' => 'C02',
                'name' => 'Monitor Komputer',
            ],
            [
                'code' => 'C03',
                'name' => 'Printer',
            ],
            [
                'code' => 'C04',
                'name' => 'Scanner',
            ],
            [
                'code' => 'C05',
                'name' => 'Tape/Radio',
            ],
            [
                'code' => 'C06',
                'name' => 'VCD/DVD Player',
            ],
            [
                'code' => 'C07',
                'name' => 'LCD/OHP',
            ],
            [
                'code' => 'C08',
                'name' => 'Kamera Foto',
            ],
            [
                'code' => 'C09',
                'name' => 'Handycam',
            ],
            [
                'code' => 'C10',
                'name' => 'Televisi',
            ],
            [
                'code' => 'C11',
                'name' => 'Speaker/Salon',
            ],
            [
                'code' => 'C12',
                'name' => 'Power/Amplifier',
            ],
            [
                'code' => 'C13',
                'name' => 'Telepon',
            ],
            [
                'code' => 'C14',
                'name' => 'UPS/Stabilizer',
            ],
            [
                'code' => 'C15',
                'name' => 'Jam Dinding',
            ],
            [
                'code' => 'C16',
                'name' => 'AC',
            ],
            [
                'code' => 'C17',
                'name' => 'Dispenser',
            ],
            [
                'code' => 'C18',
                'name' => 'Megaphone',
            ],
            [
                'code' => 'C19',
                'name' => 'Proyektor',
            ],
            [
                'code' => 'C20',
                'name' => 'Layar Proyektor',
            ],
        ];

        foreach ($inventory_codes as $code) {
            InventoryCode::create($code);
        }
    }
}
