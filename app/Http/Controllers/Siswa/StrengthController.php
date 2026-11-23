<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Strength;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StrengthController extends Controller
{
    public function index(Request $request)
    {
        $items = Strength::where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->groupBy('kind');

        return view('siswa.strengths.index', [
            'kekuatan' => $items->get('kekuatan', collect()),
            'minat'    => $items->get('minat', collect()),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kind'    => ['required', Rule::in(Strength::KINDS)],
            'title'   => ['required', 'string', 'max:100'],
            'example' => ['nullable', 'string', 'max:1000'],
        ]);

        $strength = new Strength($data);
        $strength->user_id = $request->user()->id; // dari login, bukan dari form
        $strength->save();

        return redirect()->route('siswa.strengths.index')
            ->with('status', 'Tersimpan.');
    }

    public function destroy(Strength $strength)
    {
        $this->authorize('manage', $strength);

        $strength->delete();

        return redirect()->route('siswa.strengths.index')
            ->with('status', 'Dihapus.');
    }
}