<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Submission;
use App\Models\Feedback;
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
    $totalScore = 0;
    $feedbackComments = [];

    // Fetch GitHub repository content (simplified; assumes public repo)
    $githubUrl = $submission->project->github_url;
    $repoContent = $this->fetchGitHubContent($githubUrl);

    // Call AI for a general code review
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-4',
        'messages' => [
            [
                'role' => 'system',
                'content' => "You are an expert code reviewer. Evaluate the following code and provide a score out of 10, along with the errors and corrections in JSON format: {\"score\": number, \"errors\": \"string\", \"corrections\": \"string\"}."
            ],
            [
                'role' => 'user',
                'content' => "Code: {$repoContent}"
            ]
        ],
        'max_tokens' => 500,
    ]);

    $parsed = ['score' => 5, 'errors' => 'N/A', 'corrections' => 'N/A'];
    if ($response->successful()) {
        $result = $response->json()['choices'][0]['message']['content'];
        $parsed = json_decode($result, true) ?: $parsed;
    }

    // Save feedback
    $feedback = Feedback::create([
        'submission_id' => $submission->id,
        'content' => "Errors:\n{$parsed['errors']}\n\nCorrections:\n{$parsed['corrections']}",
        'correct' => $parsed['corrections'],
        'incorrect' => $parsed['errors'],
    ]);

    // Update submission
    $submission->update([
        'score' => min($parsed['score'], 100),
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