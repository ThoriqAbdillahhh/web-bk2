<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\LifeValue;
use App\Models\PersonalityMap;
use App\Models\Strength;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $journals = $user->journals()->with('feedback')->orderBy('week_no')->get();

        $strengths = Strength::where('user_id', $user->id)->get()->groupBy('kind');

        $life = LifeValue::where('user_id', $user->id)->first();
        $items = config('life_values.items');
        $nilai = collect($life?->selected ?? [])->map(function ($key) use ($items) {
            $v = $items[$key] ?? $key;
            return is_array($v) ? ($v['label'] ?? $key) : $v;
        });

        return view('siswa.progress.index', [
            'user'      => $user->load('classroom'),
            'journals'  => $journals,
            'kekuatan'  => $strengths->get('kekuatan', collect()),
            'minat'     => $strengths->get('minat', collect()),
            'nilai'     => $nilai,
            'hasMap'    => PersonalityMap::where('user_id', $user->id)->exists(),
        ]);
    }
}