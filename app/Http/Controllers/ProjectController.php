<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Submission;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('uploads/cvs', 'public');
        }

        $project = Project::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'github_url' => $request->github_url,
            'linkedin_url' => $request->linkedin_url,
            'cv_path' => $cvPath,
        ]);

        $submission = Submission::create([
            'project_id' => $project->id,
            'status' => 'pending',
        ]);

        // Automated evaluation (simplified rubric)
        $score = $this->evaluateSubmission($request->github_url);
        $submission->update(['score' => $score, 'status' => 'reviewed']);

        Feedback::create([
            'submission_id' => $submission->id,
            'correct' => 'Good structure and documentation.',
            'incorrect' => 'Consider adding error handling and optimizing performance.',
        ]);

        return redirect()->route('dashboard')->with('success', __('messages.submission_success'));
    }

    public function show(Submission $submission)
    {
        if ($submission->project->user_id !== Auth::user()->id && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('projects.show', compact('submission'));
    }

    protected function evaluateSubmission($githubUrl)
    {
        // Simplified scoring logic (replace with actual GitHub API integration)
        $codeQuality = rand(20, 40); // Max 40
        $documentation = rand(15, 30); // Max 30
        $functionality = rand(15, 30); // Max 30
        return $codeQuality + $documentation + $functionality;
    }
}
?>