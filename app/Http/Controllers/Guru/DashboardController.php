<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Reflection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        return view('guru.dashboard', [
            'sharedReflectionsToReview' => Reflection::query()
                ->where('is_shared', true)
                ->whereDoesntHave('feedback')
                ->count(),
        ]);
    }
}
