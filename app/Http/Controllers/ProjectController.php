<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Submission;
use App\Models\Feedback;
use App\Models\Rubric;
use App\Models\RubricScore;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('projects.submit-project');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $submissionCount = $user->submissions()->count();

        if ($submissionCount >= 4 && !$user->hasActivePayment()) {
            return redirect()->route('payment.required')->with('error', __('messages.payment_required'));
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'github_url' => 'required|url',
            'linkedin_url' => 'nullable|url',
            'cv' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cvPath = $request->hasFile('cv') ? $request->file('cv')->store('uploads/cvs', 'public') : null;

        $project = Project::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'github_url' => $request->github_url,
            'linkedin_url' => $request->linkedin_url,
            'cv_path' => $cvPath,
        ]);

        $submission = Submission::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'status' => 'pending',
        ]);

        // Trigger AI review
        $this->evaluateSubmission($submission);

        // Award badge for 5+ submissions
        if ($user->submissions()->count() >= 5) {
            $user->badges()->attach(Badge::firstOrCreate(['name' => '5 Submissions']));
        }

        return redirect()->route('dashboard')->with('success', __('messages.submission_success'));
    }

    public function show(Submission $submission)
    {
        if ($submission->user_id !== Auth::user()->id && Auth::user()->role !== 'admin') {
            abort(403);
        }
        $submission->load(['project', 'feedback', 'rubricScores.rubric']);
        return view('projects.show', compact('submission'));
    }

    protected function evaluateSubmission(Submission $submission)
    {
        $rubrics = Rubric::all();
        $totalScore = 0;
        $feedbackComments = [];
        $rubricScores = [];

        // Fetch GitHub repository content (simplified; assumes public repo)
        $githubUrl = $submission->project->github_url;
        $repoContent = $this->fetchGitHubContent($githubUrl);

        foreach ($rubrics as $rubric) {
            // Call GPT API for each rubric criterion
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an expert code reviewer. Evaluate the following code based on the criterion: {$rubric->criterion}. Description: {$rubric->description}. Provide a score out of 10 and detailed comments on what was done well and what needs improvement in JSON format: {\"score\": number, \"correct\": \"string\", \"incorrect\": \"string\"}."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Code: {$repoContent}"
                    ]
                ],
                'max_tokens' => 500,
            ]);

            if ($response->successful()) {
                $result = $response->json()['choices'][0]['message']['content'];
                $parsed = json_decode($result, true) ?: ['score' => 5, 'correct' => 'N/A', 'incorrect' => 'N/A'];
                $score = $parsed['score'] * $rubric->weight / 10;
                $totalScore += $score;

                $rubricScores[] = [
                    'submission_id' => $submission->id,
                    'rubric_id' => $rubric->id,
                    'score' => $parsed['score'],
                    'comments' => "Correct: {$parsed['correct']}\nIncorrect: {$parsed['incorrect']}",
                ];

                $feedbackComments[] = "{$rubric->criterion}: {$parsed['correct']}\nAreas for Improvement: {$parsed['incorrect']}";
            } else {
                $rubricScores[] = [
                    'submission_id' => $submission->id,
                    'rubric_id' => $rubric->id,
                    'score' => 5,
                    'comments' => 'Error: Unable to fetch AI review.',
                ];
                $feedbackComments[] = "{$rubric->criterion}: Error in AI review.";
            }
        }

        // Save feedback
        $feedback = Feedback::create([
            'submission_id' => $submission->id,
            'content' => implode("\n\n", $feedbackComments),
            'correct' => 'See rubric scores for details.',
            'incorrect' => 'See rubric scores for details.',
        ]);

        // Save rubric scores
        foreach ($rubricScores as $score) {
            RubricScore::create($score);
        }

        // Update submission
        $submission->update([
            'score' => min($totalScore, 100),
            'status' => 'reviewed',
            'feedback_id' => $feedback->id,
        ]);
    }

    protected function fetchGitHubContent($url)
    {
        // Simplified: Fetch main file or README (in production, use GitHub API with authentication)
        $response = Http::get($url);
        return $response->successful() ? $response->body() : 'No code available';
    }
}
?>