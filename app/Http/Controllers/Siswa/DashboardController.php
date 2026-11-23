<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $missions = Mission::query()
            ->where('is_active', true)
            ->orderBy('sequence')
            ->get();

        $progressByMission = $user->missionProgress()
            ->whereIn('mission_id', $missions->pluck('id'))
            ->get()
            ->keyBy('mission_id');

        $currentMission = null;
        $currentProgress = null;

        foreach ($missions as $mission) {
            $progress = $progressByMission->get($mission->id);

            if ($progress && $progress->status === 'completed') {
                continue;
            }

            $currentMission = $mission;

            if (! $progress) {
                $currentProgress = $user->missionProgress()->firstOrCreate(
                    ['mission_id' => $mission->id],
                    ['status' => 'available'],
                );
            } else {
                if ($progress->status === 'locked') {
                    $progress->update(['status' => 'available']);
                }

                if (! in_array($progress->status, ['available', 'in_progress'], true)) {
                    abort(409, 'Status progres misi tidak dikenali.');
                }

                $currentProgress = $progress;
            }

            break;
        }

        return view('siswa.dashboard', [
            'user' => $user,
            'currentMission' => $currentMission,
            'currentProgress' => $currentProgress,
            'completedCount' => $user->missionProgress()->where('status', 'completed')->count(),
            'totalMissions' => $missions->count(),
            'disclaimer' => config('adventure.disclaimer'),
            'latestAnswer' => $user->challengeAnswers()
                ->with('challenge.mission')
                ->latest('submitted_at')
                ->first(),
        ]);
    }
}
