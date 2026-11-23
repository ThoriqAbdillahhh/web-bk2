<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MissionController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeAdmin($request);

        $missions = Mission::query()
            ->with(['challenges.options'])
            ->orderBy('sequence')
            ->paginate(10);

        return view('admin.missions.index', compact('missions'));
    }

    public function create(Request $request): View
    {
        $this->authorizeAdmin($request);

        return view('admin.missions.form', ['mission' => new Mission]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'slug' => ['required', 'string', 'alpha_dash:ascii', 'max:100', 'unique:missions,slug'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'instructions' => ['nullable', 'string', 'max:3000'],
            'sequence' => ['required', 'integer', 'min:1', 'max:65535', 'unique:missions,sequence'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        Mission::create($data);

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Misi ditambahkan.');
    }

    public function edit(Request $request, Mission $mission): View
    {
        $this->authorizeAdmin($request);

        return view('admin.missions.form', compact('mission'));
    }

    public function update(Request $request, Mission $mission): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'slug' => ['required', 'string', 'alpha_dash:ascii', 'max:100', Rule::unique('missions', 'slug')->ignore($mission->id)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'instructions' => ['nullable', 'string', 'max:3000'],
            'sequence' => ['required', 'integer', 'min:1', 'max:65535', Rule::unique('missions', 'sequence')->ignore($mission->id)],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $mission->update($data);

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Misi diperbarui.');
    }

    public function destroy(Request $request, Mission $mission): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $hasLearnerData = $mission->progress()->exists()
            || $mission->reflections()->exists()
            || $mission->challenges()->whereHas('answers')->exists();

        if ($hasLearnerData) {
            return redirect()
                ->route('admin.missions.index')
                ->with('error', 'Misi tidak dapat dihapus karena sudah memiliki data progres siswa.');
        }

        $mission->delete();

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Misi dihapus.');
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user() instanceof User && $request->user()->hasRole('admin'), 403);
    }
}
