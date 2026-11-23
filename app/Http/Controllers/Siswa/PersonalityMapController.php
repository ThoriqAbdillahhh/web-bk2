<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PersonalityMap;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonalityMapController extends Controller
{
    public function index(Request $request)
    {
        $map = PersonalityMap::where('user_id', $request->user()->id)->first();

        return view('siswa.personality.index', [
            'dimensions' => config('personality.dimensions'),
            'options'    => PersonalityMap::ANSWERS,
            'answers'    => $map?->answers ?? [],
            'notes'      => $map?->notes ?? [],
        ]);
    }

    public function update(Request $request)
    {
        // Aturan dibuat dari config, jadi hanya pernyataan yang dikenal yang diterima
        $rules = [];
        foreach (config('personality.dimensions') as $dimKey => $dim) {
            $rules["notes.$dimKey"] = ['nullable', 'string', 'max:500'];
            foreach ($dim['statements'] as $id => $text) {
                $rules["answers.$id"] = ['nullable', Rule::in(PersonalityMap::ANSWERS)];
            }
        }

        $data = $request->validate($rules);

        $map = PersonalityMap::where('user_id', $request->user()->id)->first()
            ?? new PersonalityMap();

        $map->user_id = $request->user()->id; // dari login, bukan dari form
        $map->fill([
            'answers' => $data['answers'] ?? [],
            'notes'   => $data['notes'] ?? [],
        ]);
        $map->save();

        return redirect()->route('siswa.personality.index')
            ->with('status', 'Tersimpan.');
    }
}