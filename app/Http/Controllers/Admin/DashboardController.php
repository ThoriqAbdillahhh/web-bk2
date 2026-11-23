<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Challenge;
use App\Models\FunctionCheck;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user() instanceof User && $request->user()->hasRole('admin'), 403);

        return view('admin.dashboard', [
            'totalSiswa' => User::role('siswa')->count(),
            'totalGuru' => User::role('guru')->count(),
            'totalKelas' => Classroom::count(),
            'totalMisi' => Mission::count(),
            'totalTantangan' => Challenge::count(),
            'checksPending' => FunctionCheck::where('status', 'belum_diperiksa')->count(),
        ]);
    }
}