<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Submission;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Rubric;
use App\Models\RubricScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    public function __construct()
    { 
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $submissions = Submission::with(['user', 'project', 'feedback', 'rubricScores.rubric'])->latest()->paginate(10);
        return view('admin.projects.index', compact('submissions'));
    }

    public function create()
    {
        $users = User::where('role', 'student')->get();
        return view('admin.projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'github_url' => 'required|url',
            'linkedin_url' => 'nullable|url',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $cvPath = $request->hasFile('cv') ? $request->file('cv')->store('uploads/cvs', 'public') : null;

        $project = Project::create([
            'title' => $request->title,
            'github_url' => $request->github_url,
            'linkedin_url' => $request->linkedin_url,
            'cv_path' => $cvPath,
        ]);

        $submission = Submission::create([
            'user_id' => $request->user_id,
            'project_id' => $project->id,
            'status' => 'pending',
        ]);

        // Trigger AI review
        $this->reviewSubmission($submission);

        return redirect()->route('admin.projects.index')->with('success', __('messages.submission_created'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['user', 'project', 'feedback', 'rubricScores.rubric']);
        return view('admin.projects.show', compact('submission'));
    }

    public function destroy(Submission $submission)
    {
        if ($submission->project->cv_path) {
            Storage::disk('public')->delete($submission->project->cv_path);
        }
        $submission->project->delete();
        $submission->delete();
        return redirect()->route('admin.projects.index')->with('success', __('messages.submission_deleted'));
    }

    protected function reviewSubmission(Submission $submission)
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
                        'content' => "You are an expert code reviewer. Evaluate the following code based on the criterion: {$rubric->criterion}. Description: {$rubric->description}. Provide a score out of 10 and detailed comments on what was done well and what needs improvement."
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
                // Parse result (assuming GPT returns structured response)
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
            }
        }

        // Save feedback
        $feedback = Feedback::create([
            'submission_id' => $submission->id,
            'content' => implode("\n\n", $feedbackComments),
            'correct' => 'See rubric scores',
            'incorrect' => 'See rubric scores',
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
        // Simplified: Fetch main file or README (in production, use GitHub API to fetch repo contents)
        $response = Http::get($url);
        return $response->successful() ? $response->body() : 'No code available';
    }
}
?>