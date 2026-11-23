<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Mission;
use App\Models\MissionProgress;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        $missions = Mission::query()
            ->where('is_active', true)
            ->orderBy('sequence')
            ->get();

        $classrooms = Classroom::query()
            ->withCount([
                'users as students_count' => fn ($query) => $query->whereHas(
                    'roles',
                    fn ($roles) => $roles->where('name', 'siswa'),
                ),
            ])
            ->orderBy('name')
            ->get();

        $completedByClassAndMission = MissionProgress::query()
            ->join('users', 'users.id', '=', 'mission_progress.user_id')
            ->select([
                'users.classroom_id',
                'mission_progress.mission_id',
            ])
            ->selectRaw('COUNT(DISTINCT mission_progress.user_id) AS completed_count')
            ->where('mission_progress.status', 'completed')
            ->whereNotNull('users.classroom_id')
            ->groupBy('users.classroom_id', 'mission_progress.mission_id')
            ->get()
            ->keyBy(fn ($row) => $row->classroom_id.':'.$row->mission_id);

        $classroomItems = $classrooms->map(function (Classroom $classroom) use ($missions, $completedByClassAndMission): array {
            $missionCounts = $missions->map(function (Mission $mission) use ($classroom, $completedByClassAndMission): array {
                $key = $classroom->id.':'.$mission->id;
                $completedCount = (int) ($completedByClassAndMission->get($key)->completed_count ?? 0);

                return [
                    'mission' => $mission,
                    'completed_count' => $completedCount,
                ];
            });

            return [
                'classroom' => $classroom,
                'students_count' => $classroom->students_count,
                'missions' => $missionCounts,
            ];
        });

        return view('guru.progress.index', [
            'classroomItems' => $classroomItems,
            'missions' => $missions,
        ]);
    }
}
