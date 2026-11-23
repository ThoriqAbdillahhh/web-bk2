<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        $filter = $request->query('status');

        $consultations = Consultation::with('user.classroom')
            ->when(in_array($filter, Consultation::STATUSES), fn ($q) => $q->where('status', $filter))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('guru.consultations.index', compact('consultations', 'filter'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        $data = $request->validate([
            'status' => ['required', Rule::in(Consultation::STATUSES)],
        ]);

        $consultation->status = $data['status'];
        $consultation->save();

        return back()->with('success', 'Status diperbarui.');
    }
}