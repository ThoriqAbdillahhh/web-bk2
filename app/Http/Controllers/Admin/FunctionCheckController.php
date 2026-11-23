<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FunctionCheck;
use App\Models\User;
use Database\Seeders\FunctionCheckSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FunctionCheckController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeAdmin($request);

        $checks = FunctionCheck::query()
            ->orderBy('item_number')
            ->get()
            ->keyBy('item_number');

        return view('admin.checks.index', compact('checks'));
    }

    public function update(Request $request): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $statusOptions = ['belum_diperiksa', 'berfungsi', 'perlu_revisi'];
        $rules = [
            'checks' => ['required', 'array', 'size:'.count(FunctionCheckSeeder::ITEMS)],
        ];

        foreach (array_keys(FunctionCheckSeeder::ITEMS) as $number) {
            $rules["checks.{$number}.status"] = ['required', 'string', Rule::in($statusOptions)];
            $rules["checks.{$number}.notes"] = ['nullable', 'string', 'max:2000'];
        }

        $data = $request->validate($rules);
        $submittedItems = array_map('intval', array_keys($data['checks']));
        sort($submittedItems);
        $expectedItems = array_keys(FunctionCheckSeeder::ITEMS);
        sort($expectedItems);

        if ($submittedItems !== $expectedItems) {
            abort(422, 'Daftar item checklist tidak sesuai.');
        }

        foreach (FunctionCheckSeeder::ITEMS as $itemNumber => $title) {
            $item = $data['checks'][$itemNumber];
            $isPending = $item['status'] === 'belum_diperiksa';

            FunctionCheck::updateOrCreate(
                ['item_number' => $itemNumber],
                [
                    'title' => $title,
                    'status' => $item['status'],
                    'notes' => $item['notes'] ?? null,
                    'checked_by' => $isPending ? null : $request->user()->id,
                    'checked_at' => $isPending ? null : now(),
                ],
            );
        }

        return redirect()
            ->route('admin.checks.index')
            ->with('success', 'Checklist uji fungsi diperbarui.');
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user() instanceof User && $request->user()->hasRole('admin'), 403);
    }
}
