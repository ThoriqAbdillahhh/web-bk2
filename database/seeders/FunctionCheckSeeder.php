<?php

namespace Database\Seeders;

use App\Models\FunctionCheck;
use Illuminate\Database\Seeder;

class FunctionCheckSeeder extends Seeder
{
    public const ITEMS = [
        1 => 'Halaman pembuka dan petunjuk tampil dengan benar.',
        2 => 'Tombol mulai membuka halaman petualangan.',
        3 => 'Pengguna dapat memilih dan membuka misi.',
        4 => 'Instruksi dan pilihan jawaban tampil lengkap.',
        5 => 'Umpan balik muncul setelah respons diberikan.',
        6 => 'Pengguna dapat mencoba kembali atau lanjut ke misi berikutnya.',
        7 => 'Halaman refleksi dapat dibuka dan diisi.',
        8 => 'Navigasi kembali dan beranda berfungsi.',
        9 => 'Tidak ada nama atau data pribadi yang tampil tanpa kebutuhan.',
        10 => 'Teks, warna, dan tombol dapat dibaca atau dikenali dengan jelas.',
    ];

    public function run(): void
    {
        foreach (self::ITEMS as $itemNumber => $title) {
            FunctionCheck::firstOrCreate(
                ['item_number' => $itemNumber],
                [
                    'title' => $title,
                    'status' => 'belum_diperiksa',
                ],
            );
        }
    }
}
