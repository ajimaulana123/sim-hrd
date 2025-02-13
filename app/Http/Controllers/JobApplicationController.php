<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = JobApplication::with('jobVacancy')
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('job_vacancy_id'), function ($query, $jobId) {
                $query->where('job_vacancy_id', $jobId);
            })
            ->latest()
            ->paginate(10);

        $vacancies = JobVacancy::where('status', 'published')->get();

        return view('applications.index', compact('applications', 'vacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vacancies = JobVacancy::where('status', 'published')
            ->where('end_date', '>=', now())
            ->get();

        return view('applications.form', compact('vacancies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_vacancy_id' => 'required|exists:job_vacancies,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'additional_documents' => 'nullable|array',
            'additional_documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'expected_salary' => 'required|numeric|min:0',
        ]);

        // Upload resume
        $resumePath = $request->file('resume')->store('resumes', 'public');

        // Upload additional documents if any
        $additionalDocs = [];
        if ($request->hasFile('additional_documents')) {
            foreach ($request->file('additional_documents') as $file) {
                $additionalDocs[] = $file->store('additional_documents', 'public');
            }
        }

        JobApplication::create([
            'job_vacancy_id' => $validated['job_vacancy_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'cover_letter' => $validated['cover_letter'],
            'resume_path' => $resumePath,
            'additional_documents' => $additionalDocs,
            'expected_salary' => $validated['expected_salary'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Lamaran pekerjaan berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplication $application)
    {
        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $application)
    {
        $vacancies = JobVacancy::where('status', 'published')->get();
        return view('applications.form', compact('application', 'vacancies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'job_vacancy_id' => 'required|exists:job_vacancies,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'required|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'additional_documents' => 'nullable|array',
            'additional_documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'expected_salary' => 'required|numeric|min:0',
            'status' => 'required|in:pending,shortlisted,interviewed,rejected,hired',
            'notes' => 'nullable|string',
            'interview_date' => 'nullable|date',
            'interviewer' => 'nullable|string|max:255',
        ]);

        // Update resume if new file uploaded
        if ($request->hasFile('resume')) {
            // Delete old resume
            Storage::disk('public')->delete($application->resume_path);
            // Upload new resume
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $validated['resume_path'] = $resumePath;
        }

        // Update additional documents if new files uploaded
        if ($request->hasFile('additional_documents')) {
            // Delete old documents
            foreach ($application->additional_documents as $doc) {
                Storage::disk('public')->delete($doc);
            }
            // Upload new documents
            $additionalDocs = [];
            foreach ($request->file('additional_documents') as $file) {
                $additionalDocs[] = $file->store('additional_documents', 'public');
            }
            $validated['additional_documents'] = $additionalDocs;
        }

        $application->update($validated);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Lamaran pekerjaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $application)
    {
        // Delete files
        Storage::disk('public')->delete($application->resume_path);
        foreach ($application->additional_documents as $doc) {
            Storage::disk('public')->delete($doc);
        }

        $application->delete();

        return redirect()
            ->route('applications.index')
            ->with('success', 'Lamaran pekerjaan berhasil dihapus');
    }

    public function scheduleInterview(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'interview_date' => 'required|date|after:now',
            'interviewer' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => 'interviewed',
            'interview_date' => $validated['interview_date'],
            'interviewer' => $validated['interviewer'],
            'notes' => $validated['notes'],
        ]);

        // TODO: Send email notification to applicant

        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Jadwal interview berhasil diatur');
    }
}
