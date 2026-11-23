<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\JournalFeedback;
use App\Models\LifeValue;
use App\Models\PersonalityMap;
use App\Models\Strength;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $password = env('DEMO_PASSWORD', 'password');

        // Guru BK
        $teachers = [];
        $guruList = [
            ['Sari Wulandari, S.Pd.', 'Bu Sari', 'sari.guru@dummy.test'],
            ['Budi Hartono, S.Pd.', 'Pak Budi', 'budi.guru@dummy.test'],
        ];
        foreach ($guruList as [$name, $nick, $email]) {
            $t = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'nickname' => $nick, 'password' => $password]
            );
            $t->syncRoles(['guru']);
            $teachers[] = $t;
        }

        // Kelas dan siswa (5 siswa per kelas)
        $classNames = ['X-1', 'X-2', 'XI-1'];
        $students = [
            ['Aisyah Putri', 'Aisyah'], ['Bima Pratama', 'Bima'], ['Citra Lestari', 'Citra'],
            ['Dimas Saputra', 'Dimas'], ['Eka Rahmawati', 'Eka'],
            ['Fajar Nugroho', 'Fajar'], ['Gita Maharani', 'Gita'], ['Hadi Kurniawan', 'Hadi'],
            ['Indah Permata', 'Indah'], ['Joko Santoso', 'Joko'],
            ['Kirana Dewi', 'Kirana'], ['Lukman Hakim', 'Lukman'], ['Maya Anggraini', 'Maya'],
            ['Naufal Ramadhan', 'Naufal'], ['Olivia Sari', 'Olivia'],
        ];
        $bios = [
            'Aku suka belajar hal baru dan masih mencari tahu apa yang paling cocok untukku.',
            'Aku lebih nyaman berkelompok kecil, tapi sedang belajar berani bicara di depan kelas.',
            'Aku suka merencanakan sesuatu dengan rapi, kadang terlalu khawatir kalau hasilnya belum sempurna.',
        ];

        foreach ($classNames as $i => $className) {
            $classroom = Classroom::firstOrCreate(['name' => $className]);

            foreach (array_slice($students, $i * 5, 5) as $j => [$name, $nick]) {
                $n = $i * 5 + $j + 1;

                $student = User::firstOrCreate(
                    ['email' => sprintf('siswa%02d@dummy.test', $n)],
                    [
                        'name'         => $name,
                        'nickname'     => $nick,
                        'password'     => $password,
                        'classroom_id' => $classroom->id,
                        'bio'          => Arr::random($bios),
                    ]
                );
                $student->syncRoles(['siswa']);

                // Data isian hanya dibuat saat akun baru dibuat, jadi aman dijalankan ulang
                if ($student->wasRecentlyCreated) {
                    $this->fillStudentData($student, $teachers, $n);
                }
            }
        }
    }

    private function fillStudentData(User $s, array $teachers, int $n): void
    {
        // Kekuatan dan minat
        $kekuatan = [
            ['Suka membantu teman', 'Saat temanku kesulitan mengerjakan PR, aku menjelaskan sampai ia paham.'],
            ['Tekun', 'Aku tetap mengerjakan tugas sampai selesai walaupun butuh waktu lama.'],
            ['Mudah beradaptasi', 'Waktu pindah kelompok belajar, aku cepat akrab dengan anggota baru.'],
            ['Teliti', 'Aku biasa memeriksa ulang jawaban sebelum dikumpulkan.'],
        ];
        $minat = [
            ['Menggambar', 'Aku sering menggambar di waktu luang, terutama sketsa karakter.'],
            ['Membaca novel', 'Aku bisa membaca berjam-jam kalau ceritanya menarik.'],
            ['Olahraga futsal', 'Aku ikut latihan futsal tiap Jumat sore bersama teman sekelas.'],
            ['Memasak', 'Aku suka mencoba resep sederhana di akhir pekan.'],
        ];
        foreach (Arr::random($kekuatan, 2) as $row) {
            $this->makeStrength($s, 'kekuatan', $row);
        }
        foreach (Arr::random($minat, 2) as $row) {
            $this->makeStrength($s, 'minat', $row);
        }

        // Peta kepribadian (jawaban acak dari daftar yang ada di config, tanpa skor)
        $answers = [];
        foreach (config('personality.dimensions') as $dim) {
            foreach ($dim['statements'] as $id => $text) {
                $answers[$id] = Arr::random(PersonalityMap::ANSWERS);
            }
        }
        $map = new PersonalityMap();
        $map->user_id = $s->id;
        $map->fill(['answers' => $answers, 'notes' => []]);
        $map->save();

        // Nilai hidup
        $life = new LifeValue();
        $life->user_id = $s->id;
        $life->fill(['selected' => Arr::random(array_keys(config('life_values.items')), rand(3, 5))]);
        $life->save();

        // Jurnal refleksi (1-3 minggu), sebagian dibagikan
        $q1 = [
            'Aku belajar bahwa aku lebih fokus kalau mengerjakan tugas di pagi hari.',
            'Aku sadar aku mudah gugup kalau harus presentasi, tapi lebih tenang setelah latihan dulu.',
            'Aku baru sadar aku senang menjelaskan sesuatu ke teman.',
        ];
        $q2 = [
            'Waktu kerja kelompok, aku biasanya jadi yang mengatur pembagian tugas.',
            'Saat ada masalah dengan teman, aku cenderung diam dulu sebelum membicarakannya.',
            'Di kelas aku lebih banyak mendengarkan, tapi kalau ditanya aku bisa menjawab.',
        ];
        $q3 = [
            'Minggu depan aku mau mencoba bertanya satu kali di kelas.',
            'Aku mau membuat jadwal belajar sederhana dan mencobanya selama seminggu.',
            'Aku mau meminta pendapat teman dekat tentang kelebihanku.',
        ];
        $umpanBalik = [
            'Terima kasih sudah menuliskannya dengan jujur. Kesadaranmu tentang dirimu itu kekuatan yang baik, lanjutkan.',
            'Langkah kecil yang kamu rencanakan sudah tepat. Coba ceritakan hasilnya di jurnal minggu depan.',
            'Bagus, kamu sudah mengenali situasi yang membuatmu nyaman. Pertahankan kebiasaan itu.',
        ];

        $jumlah = ($n % 3) + 1;
        for ($w = 1; $w <= $jumlah; $w++) {
            $journal = $s->journals()->create([
                'week_no'   => $w,
                'q1'        => Arr::random($q1),
                'q2'        => Arr::random($q2),
                'q3'        => Arr::random($q3),
                'is_shared' => ($n + $w) % 2 === 0,
            ]);

            // Sebagian jurnal yang dibagikan sudah diberi umpan balik, sebagian belum
            if ($journal->is_shared && $n % 2 === 0) {
                JournalFeedback::create([
                    'journal_id' => $journal->id,
                    'teacher_id' => Arr::random($teachers)->id,
                    'content'    => Arr::random($umpanBalik),
                ]);
            }
        }

        // Konsultasi untuk sebagian siswa, dengan status berbeda
        if ($n % 3 === 0) {
            $topik = [
                'Bingung memilih jurusan untuk kelas XI',
                'Ingin belajar mengatur waktu antara belajar dan organisasi',
                'Merasa sulit bergaul di kelas baru',
            ];
            $statuses = ['menunggu', 'diproses', 'selesai'];

            $c = $s->consultations()->create(['topic' => Arr::random($topik)]);
            $c->status = $statuses[intdiv($n, 3) % 3];
            $c->save();
        }
    }

    private function makeStrength(User $s, string $kind, array $row): void
    {
        $st = new Strength(['title' => $row[0], 'example' => $row[1]]);
        $st->kind = $kind;
        $st->user_id = $s->id;
        $st->save();
    }
}