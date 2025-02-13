<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vacancies = JobVacancy::query()
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->when(request('department'), function ($query, $department) {
                $query->where('department', $department);
            })
            ->when(request('employment_type'), function ($query, $type) {
                $query->where('employment_type', $type);
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('jobs.index', compact('vacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'quota' => 'required|integer|min:1',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|gt:salary_min',
            'employment_type' => 'required|in:full_time,part_time,contract,internship',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        JobVacancy::create($validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Lowongan pekerjaan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobVacancy $job)
    {
        $job->load('applications');
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacancy $job)
    {
        return view('jobs.form', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobVacancy $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'quota' => 'required|integer|min:1',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|gt:salary_min',
            'employment_type' => 'required|in:full_time,part_time,contract,internship',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        $job->update($validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Lowongan pekerjaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobVacancy $job)
    {
        $job->delete();

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Lowongan pekerjaan berhasil dihapus');
    }
}
