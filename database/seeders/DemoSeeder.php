<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\ChallengeAnswer;
use App\Models\Classroom;
use App\Models\Consultation;
use App\Models\Mission;
use App\Models\MissionProgress;
use App\Models\Observation;
use App\Models\Reflection;
use App\Models\ReflectionFeedback;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use LogicException;

class DemoSeeder extends Seeder
{
    private const DEMO_PASSWORD = 'learning';

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            MissionSeeder::class,
        ]);

        $classrooms = collect([
            'VII-1',
            'VIII-1',
            'IX-1',
        ])->mapWithKeys(fn (string $name): array => [
            $name => Classroom::firstOrCreate(['name' => $name]),
        ]);

        $admin = $this->makeUser('DUMMY Admin', 'admin@dummy.test', 'admin', 'Admin');
        $teacher = $this->makeUser('DUMMY Guru BK', 'guru@dummy.test', 'guru', 'Guru BK');
        $students = collect([
            'VII-1' => ['name' => 'DUMMY Siswa VII-1', 'email' => 'siswa.vii@dummy.test', 'nickname' => 'Siswa A'],
            'VIII-1' => ['name' => 'DUMMY Siswa VIII-1', 'email' => 'siswa.viii@dummy.test', 'nickname' => 'Siswa B'],
            'IX-1' => ['name' => 'DUMMY Siswa IX-1', 'email' => 'siswa.ix@dummy.test', 'nickname' => 'Siswa C'],
        ])->mapWithKeys(fn (array $data, string $className): array => [
            $className => $this->makeUser(
                $data['name'],
                $data['email'],
                'siswa',
                $data['nickname'],
                $classrooms->get($className),
            ),
        ]);

        $missions = Mission::query()
            ->where('is_active', true)
            ->with(['challenges' => fn ($query) => $query->where('is_active', true)->with('options')])
            ->orderBy('sequence')
            ->get();

        if ($missions->count() !== 5) {
            throw new LogicException('Seeder demo membutuhkan lima misi aktif.');
        }

        $sharedReflection = $this->seedCompletedJourney(
            $students->get('VIII-1'),
            $missions,
            true,
        );
        $this->seedCompletedJourney(
            $students->get('IX-1'),
            $missions,
            false,
        );

        ReflectionFeedback::updateOrCreate(
            [
                'reflection_id' => $sharedReflection->id,
                'teacher_id' => $teacher->id,
            ],
            [
                'content' => 'DUMMY: Target kecil yang kamu pilih sudah jelas. Untuk langkah berikutnya, tentukan kapan kamu ingin mencobanya.',
            ],
        );

        $students->get('VII-1')->consultations()->firstOrCreate([
            'topic' => 'DUMMY: Saya ingin mencoba membuat tujuan belajar yang realistis.',
        ]);

        Observation::updateOrCreate(
            [
                'observer_id' => $teacher->id,
                'classroom_id' => $classrooms->get('VII-1')->id,
                'activity' => 'DUMMY: Uji coba petunjuk dan peta misi',
            ],
            [
                'result' => 'berfungsi',
                'notes' => 'DUMMY: Siswa dapat menemukan petunjuk dan membuka misi pertama.',
                'observed_at' => now()->subDay()->startOfDay(),
            ],
        );

        SurveyResponse::updateOrCreate(
            [
                'suggestion' => 'DUMMY: Isian contoh anonim tanpa informasi pribadi.',
            ],
            [
                'answers' => array_fill_keys(
                    array_keys(config('survey.statements')),
                    'S',
                ),
                'submitted_at' => now()->subDay(),
            ],
        );

        $this->command?->info('Akun demo dibuat untuk admin, guru BK, dan siswa kelas VII-1, VIII-1, IX-1.');
    }

    private function makeUser(
        string $name,
        string $email,
        string $role,
        ?string $nickname = null,
        ?Classroom $classroom = null,
    ): User {
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'nickname' => $nickname,
                'password' => self::DEMO_PASSWORD,
                'classroom_id' => $classroom?->id,
            ],
        );

        $user->syncRoles([$role]);

        return $user;
    }

    private function seedCompletedJourney(
        User $student,
        Collection $missions,
        bool $shareReflection,
    ): Reflection {
        foreach ($missions as $mission) {
            $challenges = $mission->challenges->sortBy([
                ['level', 'asc'],
                ['position', 'asc'],
            ])->values();

            if ($challenges->isEmpty()) {
                throw new LogicException("Misi {$mission->slug} belum memiliki tantangan aktif.");
            }

            foreach ($challenges as $challenge) {
                $this->seedCorrectAnswer($student, $challenge);
            }

            MissionProgress::updateOrCreate(
                [
                    'user_id' => $student->id,
                    'mission_id' => $mission->id,
                ],
                [
                    'status' => 'completed',
                    'started_at' => now()->subDays(6 - $mission->sequence),
                    'completed_at' => now()->subDays(5 - $mission->sequence),
                ],
            );
        }

        $reflectionMission = $missions->firstWhere('slug', 'refleksi');

        if (! $reflectionMission) {
            throw new LogicException('Misi Refleksi tidak ditemukan.');
        }

        return Reflection::updateOrCreate(
            [
                'user_id' => $student->id,
                'mission_id' => $reflectionMission->id,
            ],
            [
                'what_learned' => 'DUMMY: Saya belajar memilih target kecil dan membagi kegiatan belajar menjadi beberapa langkah.',
                'difficult_part' => 'DUMMY: Menentukan langkah pertama terasa paling menantang.',
                'next_step' => 'DUMMY: Saya akan mencoba belajar selama 20 menit dan mencatat pertanyaan.',
                'is_shared' => $shareReflection,
            ],
        );
    }

    private function seedCorrectAnswer(User $student, Challenge $challenge): void
    {
        $options = $challenge->options->sortBy('position')->values();

        if ($options->count() < 2) {
            throw new LogicException("Tantangan {$challenge->id} memerlukan sedikitnya dua pilihan.");
        }

        $answer = [
            'selected_option_id' => null,
            'answer_order' => null,
            'is_correct' => true,
            'submitted_at' => now()->subDays(1),
        ];

        if ($challenge->challenge_type === 'choice') {
            $correctOption = $options->firstWhere('is_correct', true);

            if (! $correctOption) {
                throw new LogicException("Tantangan {$challenge->id} belum memiliki pilihan yang sesuai.");
            }

            $answer['selected_option_id'] = $correctOption->id;
        } elseif ($challenge->challenge_type === 'ordering') {
            $orderedOptions = $options->sortBy('correct_position')->values();
            $positions = $orderedOptions->pluck('correct_position')->all();

            if ($positions !== range(1, $options->count())) {
                throw new LogicException("Tantangan {$challenge->id} belum memiliki urutan jawaban yang lengkap.");
            }

            $answer['answer_order'] = $orderedOptions->modelKeys();
        } else {
            throw new LogicException("Jenis tantangan {$challenge->challenge_type} tidak didukung.");
        }

        ChallengeAnswer::updateOrCreate(
            [
                'user_id' => $student->id,
                'challenge_id' => $challenge->id,
                'attempt_number' => 1,
            ],
            $answer,
        );
    }
}
