<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('siswa.profile.edit', ['user' => $request->user()->load('classroom')]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nickname' => ['nullable', 'string', 'max:50'],
            'bio'      => ['nullable', 'string', 'max:500'],
        ]);

        $request->user()->update($data);

        return back()->with('success', 'Profil diperbarui.');
    }
}