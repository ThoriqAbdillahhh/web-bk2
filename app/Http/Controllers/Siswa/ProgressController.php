<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $missions = Mission::query()
            ->where('is_active', true)
            ->with([
                'progress' => fn ($query) => $query->where('user_id', $user->id),
                'challenges' => fn ($query) => $query->where('is_active', true),
            ])
            ->orderBy('sequence')
            ->get();

        $challengeIds = $missions->flatMap(
            fn (Mission $mission) => $mission->challenges->pluck('id'),
        );
        $answersByChallenge = $user->challengeAnswers()
            ->whereIn('challenge_id', $challengeIds)
            ->orderBy('created_at')
            ->get()
            ->groupBy('challenge_id');

        $reflectionsByMission = $user->reflections()
            ->with('feedback.teacher')
            ->whereIn('mission_id', $missions->pluck('id'))
            ->latest()
            ->get()
            ->groupBy('mission_id');

        $missionItems = $missions->map(function (Mission $mission) use ($answersByChallenge, $reflectionsByMission): array {
            $progress = $mission->progress->first();
            $challengeItems = $mission->challenges->map(function ($challenge) use ($answersByChallenge): array {
                $answers = $answersByChallenge->get($challenge->id, collect());

                return [
                    'challenge' => $challenge,
                    'attempts' => $answers->count(),
                    'completed' => $answers->contains(
                        fn ($answer) => $answer->is_correct === true,
                    ),
                    'last_attempt' => $answers->last(),
                ];
            });

            return [
                'mission' => $mission,
                'status' => $progress?->status ?? 'locked',
                'started_at' => $progress?->started_at,
                'completed_at' => $progress?->completed_at,
                'challenges' => $challengeItems,
                'reflections' => $reflectionsByMission->get($mission->id, collect()),
            ];
        });

        return view('siswa.progress.index', [
            'user' => $user->load('classroom'),
            'missionItems' => $missionItems,
            'completedCount' => $missions->filter(
                fn (Mission $mission) => $mission->progress->first()?->status === 'completed',
            )->count(),
            'totalMissions' => $missions->count(),
        ]);
    }
}
