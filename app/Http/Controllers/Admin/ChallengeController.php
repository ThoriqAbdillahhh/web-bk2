<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ChallengeController extends Controller
{
    public function create(Request $request, Mission $mission): View
    {
        $this->authorizeAdmin($request);

        return view('admin.challenges.form', [
            'mission' => $mission,
            'challenge' => new Challenge,
            'options' => [
                $this->emptyOption(),
                $this->emptyOption(),
            ],
            'optionsLocked' => false,
        ]);
    }

    public function store(Request $request, Mission $mission): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $this->validateChallenge($request, $mission);
        $options = $data['options'];
        unset($data['options']);
        $data['is_active'] = $request->boolean('is_active');

        DB::transaction(function () use ($mission, $data, $options): void {
            $challenge = $mission->challenges()->create($data);
            $this->replaceOptions($challenge, $options);
        });

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Tantangan dan pilihan umpan balik ditambahkan.');
    }

    public function edit(Request $request, Mission $mission, Challenge $challenge): View
    {
        $this->authorizeAdmin($request);
        $this->ensureBelongsToMission($mission, $challenge);

        $options = $challenge->options()->orderBy('position')->get()->map(
            fn ($option): array => [
                'key' => 'option-'.$option->id,
                'label' => $option->label,
                'feedback' => $option->feedback,
                'is_correct' => $option->is_correct,
                'correct_position' => $option->correct_position,
            ],
        )->all();

        return view('admin.challenges.form', [
            'mission' => $mission,
            'challenge' => $challenge,
            'options' => old('options', $options),
            'optionsLocked' => $challenge->answers()->exists(),
        ]);
    }

    public function update(Request $request, Mission $mission, Challenge $challenge): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $this->ensureBelongsToMission($mission, $challenge);

        $optionsLocked = $challenge->answers()->exists();
        $data = $this->validateChallenge($request, $mission, $challenge, $optionsLocked);
        $options = $data['options'] ?? null;
        unset($data['options']);
        $data['is_active'] = $request->boolean('is_active');

        DB::transaction(function () use ($challenge, $data, $options, $optionsLocked): void {
            $challenge->update($data);

            if (! $optionsLocked && $options !== null) {
                $this->replaceOptions($challenge, $options);
            }
        });

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Tantangan diperbarui.');
    }

    public function destroy(Request $request, Mission $mission, Challenge $challenge): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $this->ensureBelongsToMission($mission, $challenge);

        if ($challenge->answers()->exists()) {
            return redirect()
                ->route('admin.missions.index')
                ->with('error', 'Tantangan tidak dapat dihapus karena sudah memiliki jawaban siswa.');
        }

        $challenge->delete();

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Tantangan dihapus.');
    }

    private function validateChallenge(
        Request $request,
        Mission $mission,
        ?Challenge $challenge = null,
        bool $optionsLocked = false,
    ): array {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'prompt' => ['required', 'string', 'max:3000'],
            'instructions' => ['nullable', 'string', 'max:3000'],
            'challenge_type' => ['required', 'string', 'in:choice,ordering'],
            'level' => ['required', 'integer', 'min:1', 'max:20'],
            'position' => ['required', 'integer', 'min:1', 'max:65535'],
        ];

        if (! $optionsLocked) {
            $rawOptions = $request->input('options', []);
            $options = array_values(array_filter(
                is_array($rawOptions) ? $rawOptions : [],
                fn ($option) => is_array($option) && filled($option['label'] ?? null),
            ));

            foreach ($options as &$option) {
                $option['is_correct'] = $request->input('challenge_type') === 'choice'
                    && filter_var($option['is_correct'] ?? false, FILTER_VALIDATE_BOOLEAN);
            }
            unset($option);

            $request->merge(['options' => $options]);
            $rules += [
                'options' => ['required', 'array', 'min:2', 'max:6'],
                'options.*.label' => ['required', 'string', 'max:1000'],
                'options.*.feedback' => ['required', 'string', 'max:2000'],
                'options.*.is_correct' => ['boolean'],
                'options.*.correct_position' => ['nullable', 'integer', 'min:1', 'max:6'],
            ];
        }

        $data = $request->validate($rules);

        if ($optionsLocked && $challenge->challenge_type !== $data['challenge_type']) {
            throw ValidationException::withMessages([
                'challenge_type' => 'Jenis tantangan tidak dapat diubah karena sudah memiliki jawaban siswa.',
            ]);
        }

        $duplicatePosition = $mission->challenges()
            ->where('level', $data['level'])
            ->where('position', $data['position'])
            ->when($challenge, fn ($query) => $query->where('id', '<>', $challenge->id))
            ->exists();

        if ($duplicatePosition) {
            throw ValidationException::withMessages([
                'position' => 'Urutan tantangan pada tingkat ini sudah digunakan.',
            ]);
        }

        if ($optionsLocked) {
            return $data;
        }

        if ($data['challenge_type'] === 'choice') {
            if (! collect($data['options'])->contains(fn ($option) => $option['is_correct'])) {
                throw ValidationException::withMessages([
                    'options' => 'Tandai sedikitnya satu pilihan yang sesuai.',
                ]);
            }

            foreach ($data['options'] as &$option) {
                $option['correct_position'] = null;
            }
            unset($option);
        } else {
            foreach ($data['options'] as &$option) {
                $option['is_correct'] = null;
            }
            unset($option);

            $positions = array_map(
                fn ($option) => $option['correct_position'] ?? null,
                $data['options'],
            );
            sort($positions);

            if ($positions !== range(1, count($data['options']))) {
                throw ValidationException::withMessages([
                    'options' => 'Urutan benar harus berisi angka berurutan tanpa duplikasi.',
                ]);
            }
        }

        return $data;
    }

    private function replaceOptions(Challenge $challenge, array $options): void
    {
        $challenge->options()->delete();

        foreach (array_values($options) as $index => $option) {
            unset($option['position']);
            $challenge->options()->create($option + ['position' => $index + 1]);
        }
    }

    private function ensureBelongsToMission(Mission $mission, Challenge $challenge): void
    {
        abort_unless((int) $challenge->mission_id === (int) $mission->id, 404);
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user() instanceof User && $request->user()->hasRole('admin'), 403);
    }

    private function emptyOption(): array
    {
        return [
            'key' => 'new-'.uniqid(),
            'label' => '',
            'feedback' => '',
            'is_correct' => false,
            'correct_position' => null,
        ];
    }
}
