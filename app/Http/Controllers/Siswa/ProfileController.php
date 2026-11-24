<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('siswa.profile.edit', [
            'user' => $request->user()->load('classroom'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nickname' => ['required', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->user()->update($data);

        return redirect()
            ->route('siswa.profile.edit')
            ->with('success', 'Profil diperbarui.');
    }
}