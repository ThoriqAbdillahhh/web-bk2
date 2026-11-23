<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SurveyRecapController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->hasRole('guru'), 403);

        $statements = config('survey.statements');
        $choiceKeys = array_keys(config('survey.choices'));
        $responses = SurveyResponse::query()->get(['answers']);
        $summary = [];

        foreach ($statements as $number => $statement) {
            $counts = array_fill_keys($choiceKeys, 0);

            foreach ($responses as $response) {
                $answer = $response->answers[$number] ?? null;

                if (isset($counts[$answer])) {
                    $counts[$answer]++;
                }
            }

            $summary[$number] = [
                'statement' => $statement,
                'counts' => $counts,
            ];
        }

        $suggestions = SurveyResponse::query()
            ->whereNotNull('suggestion')
            ->where('suggestion', '<>', '')
            ->latest('submitted_at')
            ->paginate(10);

        return view('guru.survey.index', [
            'summary' => $summary,
            'choices' => config('survey.choices'),
            'responseCount' => $responses->count(),
            'suggestions' => $suggestions,
        ]);
    }
}
