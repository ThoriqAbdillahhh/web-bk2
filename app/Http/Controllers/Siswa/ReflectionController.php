<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReflectionController extends Controller
{
    public function store(Request $request, Mission $mission): RedirectResponse
    {
        $user = $request->user();

        if (! $mission->is_active || $mission->slug !== 'refleksi') {
            abort(404);
        }

        $activeMissionIds = Mission::query()
            ->where('is_active', true)
            ->orderBy('sequence')
            ->pluck('id');
        $missionIndex = $activeMissionIds->search(
            fn ($id) => (int) $id === (int) $mission->id,
        );

        if ($missionIndex === false) {
            abort(404);
        }

        $previousMissionIds = $activeMissionIds->take($missionIndex);
        $completedPreviousMissions = $user->missionProgress()
            ->whereIn('mission_id', $previousMissionIds)
            ->where('status', 'completed')
            ->count();

        if ($completedPreviousMissions !== $previousMissionIds->count()) {
            abort(404);
        }

        $progress = $user->missionProgress()
            ->where('mission_id', $mission->id)
            ->whereIn('status', ['available', 'in_progress'])
            ->first();

        if (! $progress) {
            abort(404);
        }

        $challengeIds = $mission->challenges()
            ->where('is_active', true)
            ->pluck('id');

        if ($challengeIds->isEmpty()) {
            abort(409, 'Tantangan refleksi belum tersedia.');
        }

        $completedCount = $user->challengeAnswers()
            ->whereIn('challenge_id', $challengeIds)
            ->where('is_correct', true)
            ->distinct()
            ->count('challenge_id');

        if ($completedCount !== $challengeIds->count()) {
            abort(403, 'Selesaikan tantangan refleksi terlebih dahulu.');
        }

        $data = $request->validate([
            'what_learned' => ['required', 'string', 'max:3000'],
            'difficult_part' => ['required', 'string', 'max:3000'],
            'next_step' => ['required', 'string', 'max:3000'],
            'is_shared' => ['sometimes', 'boolean'],
        ]);

        $reflection = DB::transaction(function () use ($user, $mission, $progress, $data) {
            $reflection = $user->reflections()->create([
                'mission_id' => $mission->id,
                'what_learned' => $data['what_learned'],
                'difficult_part' => $data['difficult_part'],
                'next_step' => $data['next_step'],
                'is_shared' => $data['is_shared'] ?? false,
            ]);

            $progress->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            return $reflection;
        });

        return redirect()
            ->route('siswa.missions.show', $mission)
            ->with('reflection_saved', true)
            ->with('reflection_status', $reflection->is_shared ? 'dibagikan' : 'privat');
    }
}
