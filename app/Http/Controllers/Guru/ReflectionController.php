<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Reflection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReflectionController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        $reflections = Reflection::query()
            ->where('is_shared', true)
            ->with(['user.classroom', 'mission'])
            ->withCount('feedback')
            ->latest()
            ->paginate(10);

        return view('guru.reflections.index', compact('reflections'));
    }

    public function show(Request $request, Reflection $reflection): View
    {
        abort_unless($request->user()->hasRole('guru'), 403);
        abort_unless($reflection->is_shared, 404);

        $reflection->load(['user.classroom', 'mission', 'feedback.teacher']);

        return view('guru.reflections.show', compact('reflection'));
    }

    public function feedback(Request $request, Reflection $reflection): RedirectResponse
    {
        abort_unless($request->user()->hasRole('guru'), 403);
        abort_unless($reflection->is_shared, 404);

        $data = $request->validate([
            'content' => ['required', 'string', 'max:3000'],
        ]);

        $request->user()->reflectionFeedback()->create([
            'reflection_id' => $reflection->id,
            'content' => $data['content'],
        ]);

        return redirect()
            ->route('guru.reflections.show', $reflection)
            ->with('success', 'Umpan balik tersimpan.');
    }
}
