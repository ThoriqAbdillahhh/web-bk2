<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeOption;
use App\Models\Mission;
use App\Models\MissionProgress;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use LogicException;

class AdventureController extends Controller
{
    public function guide(): View
    {
        return view('siswa.guide', [
            'intro' => config('adventure.intro'),
            'disclaimer' => config('adventure.disclaimer'),
            'privacyNotice' => config('adventure.reflection_privacy_notice'),
            'missions' => Mission::query()
                ->where('is_active', true)
                ->orderBy('sequence')
                ->get(),
        ]);
    }

    public function map(Request $request): View
    {
        $user = $request->user();
        $missions = Mission::query()
            ->where('is_active', true)
            ->withCount(['challenges' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sequence')
            ->get();

        $progressByMission = $user->missionProgress()
            ->whereIn('mission_id', $missions->pluck('id'))
            ->get()
            ->keyBy('mission_id');

        $canAccessNext = true;
        $missionItems = [];

        foreach ($missions as $mission) {
            $progress = $progressByMission->get($mission->id);

            if (! $canAccessNext) {
                $status = 'locked';
            } elseif ($progress && $progress->status === 'completed') {
                $status = 'completed';
            } else {
                if (! $progress) {
                    $progress = $user->missionProgress()->firstOrCreate(
                        ['mission_id' => $mission->id],
                        ['status' => 'available'],
                    );
                } elseif ($progress->status === 'locked') {
                    $progress->update(['status' => 'available']);
                }

                if (! in_array($progress->status, ['available', 'in_progress'], true)) {
                    abort(409, 'Status progres misi tidak dikenali.');
                }

                $status = $progress->status;
                $canAccessNext = false;
            }

            $missionItems[] = [
                'mission' => $mission,
                'status' => $status,
            ];
        }

        return view('siswa.missions.map', [
            'missionItems' => $missionItems,
            'disclaimer' => config('adventure.disclaimer'),
        ]);
    }

    public function show(Request $request, Mission $mission): View
    {
        $user = $request->user();
        $progress = $this->accessibleProgress($user, $mission, true);
        $challenges = $this->activeChallenges($mission);
        $answerGroups = $user->challengeAnswers()
            ->whereIn('challenge_id', $challenges->modelKeys())
            ->orderBy('created_at')
            ->get()
            ->groupBy('challenge_id');
        $currentChallenge = $this->firstIncompleteChallenge($user, $challenges);

        $challengeStates = $challenges->map(function (Challenge $challenge) use ($answerGroups, $currentChallenge): array {
            $answers = $answerGroups->get($challenge->id, collect());
            $isComplete = $answers->contains(
                fn ($answer) => $answer->is_correct === true,
            );

            if ($isComplete) {
                $status = 'completed';
            } elseif ($currentChallenge && $currentChallenge->is($challenge)) {
                $status = $answers->isEmpty() ? 'available' : 'in_progress';
            } else {
                $status = 'locked';
            }

            return [
                'challenge' => $challenge,
                'status' => $status,
                'attempt_count' => $answers->count(),
            ];
        });

        return view('siswa.missions.show', [
            'mission' => $mission,
            'progress' => $progress,
            'challengeStates' => $challengeStates,
            'currentChallenge' => $currentChallenge,
            'feedback' => session('challenge_feedback'),
            'allChallengesComplete' => $challenges->isNotEmpty() && $currentChallenge === null,
        ]);
    }

    public function answer(Request $request, Mission $mission, Challenge $challenge): RedirectResponse
    {
        $user = $request->user();
        $progress = $this->accessibleProgress($user, $mission, true);

        if ((int) $challenge->mission_id !== (int) $mission->id || ! $challenge->is_active) {
            abort(404);
        }

        $challenges = $this->activeChallenges($mission);
        $currentChallenge = $this->firstIncompleteChallenge($user, $challenges);

        if (! $currentChallenge || ! $currentChallenge->is($challenge)) {
            abort(404);
        }

        $options = $challenge->options()->orderBy('position')->get();

        if ($options->isEmpty()) {
            abort(409, 'Tantangan ini belum memiliki pilihan.');
        }

        $selectedOptionId = null;
        $answerOrder = null;

        if ($challenge->challenge_type === 'choice') {
            $data = $request->validate([
                'selected_option_id' => ['required', 'integer'],
            ]);

            $selectedOption = $options->firstWhere('id', (int) $data['selected_option_id']);

            if (! $selectedOption) {
                throw ValidationException::withMessages([
                    'selected_option_id' => 'Pilih salah satu pilihan pada tantangan ini.',
                ]);
            }

            $isCorrect = $selectedOption->is_correct === true;
            $feedbackMessage = $this->optionFeedback($selectedOption);
            $selectedOptionId = $selectedOption->id;
        } elseif ($challenge->challenge_type === 'ordering') {
            $optionIds = $options->modelKeys();
            $data = $request->validate([
                'answer_order' => ['required', 'array', 'size:'.$options->count()],
                'answer_order.*' => ['required', 'integer', 'distinct', Rule::in($optionIds)],
            ]);

            $answerOrder = array_map('intval', $data['answer_order']);
            $correctOptions = $options->sortBy('correct_position')->values();
            $correctPositions = $correctOptions->pluck('correct_position')->all();

            if (in_array(null, $correctPositions, true)
                || count(array_unique($correctPositions)) !== $options->count()
                || $correctPositions !== range(1, $options->count())) {
                throw new LogicException('Urutan benar pada pilihan tantangan belum dikonfigurasi dengan lengkap.');
            }

            $correctOrder = array_map('intval', $correctOptions->modelKeys());
            $isCorrect = $answerOrder === $correctOrder;

            if ($isCorrect) {
                $feedbackMessage = $correctOptions
                    ->map(fn (ChallengeOption $option) => $this->optionFeedback($option))
                    ->implode(' ');
            } else {
                $firstMismatch = 0;

                foreach ($correctOrder as $index => $optionId) {
                    if ($answerOrder[$index] !== $optionId) {
                        $firstMismatch = $index;
                        break;
                    }
                }

                $nextOption = $correctOptions->get($firstMismatch);
                $feedbackMessage = 'Urutan ini lebih mudah diikuti jika langkah “'.$nextOption->label.'” dilakukan berikutnya. '
                    .$this->optionFeedback($nextOption);
            }
        } else {
            abort(409, 'Jenis tantangan tidak dikenali.');
        }

        $attemptNumber = $user->challengeAnswers()
            ->where('challenge_id', $challenge->id)
            ->count() + 1;

        $completion = DB::transaction(function () use (
            $user,
            $mission,
            $progress,
            $challenge,
            $challenges,
            $selectedOptionId,
            $answerOrder,
            $attemptNumber,
            $isCorrect
        ): array {
            $user->challengeAnswers()->create([
                'challenge_id' => $challenge->id,
                'selected_option_id' => $selectedOptionId,
                'answer_order' => $answerOrder,
                'attempt_number' => $attemptNumber,
                'is_correct' => $isCorrect,
                'submitted_at' => now(),
            ]);

            $correctChallengeIds = $user->challengeAnswers()
                ->whereIn('challenge_id', $challenges->modelKeys())
                ->where('is_correct', true)
                ->distinct()
                ->pluck('challenge_id')
                ->map(fn ($id) => (int) $id);

            $allChallengesComplete = $challenges->isNotEmpty()
                && $challenges->every(
                    fn (Challenge $item) => $correctChallengeIds->contains((int) $item->id),
                );

            $missionComplete = false;
            $awaitingReflection = false;

            if ($allChallengesComplete && $mission->slug === 'refleksi') {
                $awaitingReflection = true;
            } elseif ($allChallengesComplete) {
                $progress->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
                $missionComplete = true;

                $nextMission = Mission::query()
                    ->where('is_active', true)
                    ->where('sequence', '>', $mission->sequence)
                    ->orderBy('sequence')
                    ->first();

                if ($nextMission) {
                    $nextProgress = $user->missionProgress()->firstOrCreate(
                        ['mission_id' => $nextMission->id],
                        ['status' => 'available'],
                    );

                    if ($nextProgress->status === 'locked') {
                        $nextProgress->update(['status' => 'available']);
                    }
                }
            }

            return [
                'mission_complete' => $missionComplete,
                'awaiting_reflection' => $awaitingReflection,
            ];
        });

        return redirect()
            ->route('siswa.missions.show', $mission)
            ->withFragment('tantangan')
            ->with('challenge_feedback', [
                'challenge_id' => $challenge->id,
                'challenge_title' => $challenge->title,
                'status' => $isCorrect ? 'completed' : 'in_progress',
                'label' => $isCorrect ? 'Langkah tersimpan' : 'Coba pendekatan lain',
                'message' => $feedbackMessage,
                'is_correct' => $isCorrect,
                'mission_complete' => $completion['mission_complete'],
                'awaiting_reflection' => $completion['awaiting_reflection'],
            ]);
    }

    public function retry(Request $request, Mission $mission, Challenge $challenge): RedirectResponse
    {
        $user = $request->user();
        $this->accessibleProgress($user, $mission, true);

        if ((int) $challenge->mission_id !== (int) $mission->id || ! $challenge->is_active) {
            abort(404);
        }

        $currentChallenge = $this->firstIncompleteChallenge(
            $user,
            $this->activeChallenges($mission),
        );

        if (! $currentChallenge || ! $currentChallenge->is($challenge)) {
            abort(404);
        }

        $hasAttempt = $user->challengeAnswers()
            ->where('challenge_id', $challenge->id)
            ->exists();

        if (! $hasAttempt) {
            abort(404);
        }

        return redirect()
            ->route('siswa.missions.show', $mission)
            ->withFragment('tantangan');
    }

    private function accessibleProgress(User $user, Mission $mission, bool $begin): MissionProgress
    {
        if (! $mission->is_active) {
            abort(404);
        }

        $missionIds = Mission::query()
            ->where('is_active', true)
            ->orderBy('sequence')
            ->pluck('id');
        $missionIndex = $missionIds->search(
            fn ($id) => (int) $id === (int) $mission->id,
        );

        if ($missionIndex === false) {
            abort(404);
        }

        $previousMissionIds = $missionIds->take($missionIndex);

        if ($previousMissionIds->isNotEmpty()) {
            $completedPreviousMissions = $user->missionProgress()
                ->whereIn('mission_id', $previousMissionIds)
                ->where('status', 'completed')
                ->count();

            if ($completedPreviousMissions !== $previousMissionIds->count()) {
                abort(404);
            }
        }

        $progress = $user->missionProgress()->firstOrCreate(
            ['mission_id' => $mission->id],
            ['status' => 'available'],
        );

        if ($progress->status === 'locked') {
            $progress->update(['status' => 'available']);
        }

        if (! in_array($progress->status, ['available', 'in_progress', 'completed'], true)) {
            abort(409, 'Status progres misi tidak dikenali.');
        }

        if ($begin && $progress->status === 'available') {
            $progress->update([
                'status' => 'in_progress',
                'started_at' => $progress->started_at ?? now(),
            ]);
        }

        return $progress;
    }

    private function activeChallenges(Mission $mission): EloquentCollection
    {
        return $mission->challenges()
            ->where('is_active', true)
            ->with('options')
            ->orderBy('level')
            ->orderBy('position')
            ->get();
    }

    private function firstIncompleteChallenge(User $user, EloquentCollection $challenges): ?Challenge
    {
        if ($challenges->isEmpty()) {
            return null;
        }

        $completedChallengeIds = $user->challengeAnswers()
            ->whereIn('challenge_id', $challenges->modelKeys())
            ->where('is_correct', true)
            ->distinct()
            ->pluck('challenge_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        return $challenges->first(
            fn (Challenge $challenge) => ! in_array((int) $challenge->id, $completedChallengeIds, true),
        );
    }

    private function optionFeedback(ChallengeOption $option): string
    {
        if (blank($option->feedback)) {
            throw new LogicException('Setiap pilihan tantangan harus memiliki penjelasan umpan balik.');
        }

        return $option->feedback;
    }
}
