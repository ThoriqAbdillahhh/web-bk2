<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $journals = $request->user()->journals()->with('feedback')->orderByDesc('week_no')->get();
        return view('siswa.journals.index', compact('journals'));
    }

    public function create()
    {
        return view('siswa.journals.form', ['journal' => new Journal]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $request->user()->journals()->create($data);

        return redirect()->route('siswa.journals.index')->with('success', 'Jurnal disimpan.');
    }

    public function edit(Journal $journal)
    {
        $this->authorize('manage', $journal);
        return view('siswa.journals.form', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $this->authorize('manage', $journal);
        $journal->update($this->validated($request, $journal));

        return redirect()->route('siswa.journals.index')->with('success', 'Jurnal diperbarui.');
    }

    public function destroy(Journal $journal)
    {
        $this->authorize('manage', $journal);
        $journal->delete();

        return redirect()->route('siswa.journals.index')->with('success', 'Jurnal dihapus.');
    }

    private function validated(Request $request, ?Journal $journal = null): array
    {
        $data = $request->validate([
            'week_no' => [
                'required', 'integer', 'min:1', 'max:52',
                Rule::unique('journals', 'week_no')
                    ->where('user_id', $request->user()->id)
                    ->ignore($journal?->id),
            ],
            'q1' => ['required', 'string', 'max:2000'],
            'q2' => ['required', 'string', 'max:2000'],
            'q3' => ['required', 'string', 'max:2000'],
        ]);

        $data['is_shared'] = $request->boolean('is_shared');

        return $data;
    }
}