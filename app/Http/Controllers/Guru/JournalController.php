<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\JournalFeedback;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::where('is_shared', true)
            ->with(['user.classroom', 'feedback'])
            ->latest('updated_at')
            ->paginate(10);

        return view('guru.journals.index', compact('journals'));
    }

    public function show(Journal $journal)
    {
        $this->authorize('review', $journal);
        $journal->load(['user.classroom', 'feedback']);

        return view('guru.journals.show', compact('journal'));
    }

    public function feedback(Request $request, Journal $journal)
    {
        $this->authorize('review', $journal);

        $data = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        JournalFeedback::updateOrCreate(
            ['journal_id' => $journal->id],
            ['content' => $data['content'], 'teacher_id' => $request->user()->id]
        );

        return back()->with('success', 'Umpan balik disimpan.');
    }
}