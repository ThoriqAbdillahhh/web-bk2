<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Observation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ObservationController extends Controller
{
    private const RESULTS = ['berfungsi', 'perlu_revisi', 'belum_diperiksa'];

    public function index(Request $request): View
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        return view('guru.observations.index', [
            'classrooms' => Classroom::query()->orderBy('name')->get(),
            'observations' => Observation::query()
                ->with(['classroom', 'observer'])
                ->latest('observed_at')
                ->paginate(10),
            'results' => self::RESULTS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        $data = $request->validate([
            'classroom_id' => ['required', 'integer', 'exists:classrooms,id'],
            'activity' => ['required', 'string', 'max:255'],
            'result' => ['required', 'string', Rule::in(self::RESULTS)],
            'notes' => ['nullable', 'string', 'max:3000'],
            'observed_at' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $request->user()->observationsMade()->create($data);

        return redirect()
            ->route('guru.observations.index')
            ->with('success', 'Catatan observasi tersimpan.');
    }

    public function destroy(Request $request, Observation $observation): RedirectResponse
    {
        abort_unless($request->user()->hasRole('guru'), 403);
        abort_unless((int) $observation->observer_id === (int) $request->user()->id, 403);

        $observation->delete();

        return redirect()
            ->route('guru.observations.index')
            ->with('success', 'Catatan observasi dihapus.');
    }
}
