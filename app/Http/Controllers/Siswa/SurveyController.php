<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SurveyController extends Controller
{
    public function show(Request $request): View
    {
        return view('siswa.survey.show', [
            'statements' => config('survey.statements'),
            'choices' => config('survey.choices'),
            'alreadySubmitted' => $request->session()->get('survey_submitted', false),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $statements = config('survey.statements');
        $choiceKeys = array_keys(config('survey.choices'));
        $rules = [
            'suggestion' => ['nullable', 'string', 'max:2000'],
        ];

        foreach (array_keys($statements) as $number) {
            $rules["answers.{$number}"] = ['required', 'string', Rule::in($choiceKeys)];
        }

        $data = $request->validate($rules);
        $answers = $data['answers'];
        ksort($answers);

        SurveyResponse::create([
            'answers' => $answers,
            'suggestion' => $data['suggestion'] ?? null,
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('siswa.survey.show')
            ->with('survey_submitted', true);
    }
}
