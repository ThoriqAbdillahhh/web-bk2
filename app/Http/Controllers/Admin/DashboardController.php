<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classroom;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalSiswa' => User::role('siswa')->count(),
            'totalGuru'  => User::role('guru')->count(),
            'totalKelas' => Classroom::count(),
        ]);
    }
}