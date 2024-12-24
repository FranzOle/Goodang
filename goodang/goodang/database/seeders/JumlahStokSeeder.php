<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JumlahStok;

class JumlahStokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_barang' => 3, 'id_gudang' => 2, 'kuantitas' => 10],
        ];

        foreach ($data as $item) {
            // Mencari data yang ada atau membuat data baru jika belum ada
            $jumlahStok = JumlahStok::firstOrNew(
                ['id_barang' => $item['id_barang'], 'id_gudang' => $item['id_gudang']]
            );

            // Menambahkan kuantitas jika data sudah ada
            $jumlahStok->kuantitas += $item['kuantitas']; // Menambahkan kuantitas
            $jumlahStok->save(); // Menyimpan perubahan
        }
    }
}
