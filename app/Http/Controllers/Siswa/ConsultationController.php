<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $consultations = $request->user()->consultations()->latest()->get();

        return view('siswa.consultations.index', compact('consultations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->consultations()->create($data);

        return redirect()->route('siswa.consultations.index')
            ->with('success', 'Permintaan konsultasi terkirim.');
    }
}