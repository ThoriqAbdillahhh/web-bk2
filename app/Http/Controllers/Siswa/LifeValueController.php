<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\LifeValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LifeValueController extends Controller
{
    public function index(Request $request)
    {
        $row = LifeValue::where('user_id', $request->user()->id)->first();

        return view('siswa.life_values.index', [
            'items'    => config('life_values.items'),
            'selected' => $row?->selected ?? [],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'selected'   => ['nullable', 'array'],
            'selected.*' => ['string', 'distinct', Rule::in(array_keys(config('life_values.items')))],
        ]);

        $row = LifeValue::where('user_id', $request->user()->id)->first()
            ?? new LifeValue();

        $row->user_id = $request->user()->id; // dari login, bukan dari form
        $row->fill(['selected' => array_values($data['selected'] ?? [])]);
        $row->save();

        return redirect()->route('siswa.life_values.index')
            ->with('status', 'Tersimpan.');
    }
}