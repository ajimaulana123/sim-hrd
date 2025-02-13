<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = Leave::with(['employee', 'approver'])
            ->when(request('search'), function ($query, $search) {
                $query->whereHas('employee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('employee_id', 'like', "%{$search}%");
                });
            })
            ->when(request('employee_id'), function ($query, $employeeId) {
                $query->where('employee_id', $employeeId);
            })
            ->when(request('type'), function ($query, $type) {
                $query->where('type', $type);
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        $employees = Employee::active()->get();

        return view('leaves.index', compact('leaves', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::active()->get();
        return view('leaves.form', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:annual,sick,maternity,paternity,unpaid',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Calculate duration
        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $duration = $start->diffInDays($end) + 1;

        // Upload attachment if any
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave-attachments', 'public');
        }

        Leave::create([
            'employee_id' => $validated['employee_id'],
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'duration' => $duration,
            'reason' => $validated['reason'],
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('leaves.index')
            ->with('success', 'Pengajuan cuti berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        $leave->load(['employee', 'approver']);

        // Jika data leave tidak ditemukan, redirect ke index
        if (!$leave) {
            return redirect()
                ->route('leaves.index')
                ->with('error', 'Data cuti tidak ditemukan');
        }

        return view('leaves.show', compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()
                ->route('leaves.show', $leave)
                ->with('error', 'Pengajuan cuti yang sudah diproses tidak dapat diubah');
        }

        $employees = Employee::active()->get();
        return view('leaves.form', compact('leave', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()
                ->route('leaves.show', $leave)
                ->with('error', 'Pengajuan cuti yang sudah diproses tidak dapat diubah');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:annual,sick,maternity,paternity,unpaid',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Calculate duration
        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $duration = $start->diffInDays($end) + 1;

        // Update attachment if new file uploaded
        if ($request->hasFile('attachment')) {
            // Delete old attachment
            if ($leave->attachment_path) {
                Storage::disk('public')->delete($leave->attachment_path);
            }
            // Upload new attachment
            $validated['attachment_path'] = $request->file('attachment')->store('leave-attachments', 'public');
        }

        $leave->update($validated + ['duration' => $duration]);

        return redirect()
            ->route('leaves.index')
            ->with('success', 'Pengajuan cuti berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()
                ->route('leaves.show', $leave)
                ->with('error', 'Pengajuan cuti yang sudah diproses tidak dapat dihapus');
        }

        // Delete attachment if exists
        if ($leave->attachment_path) {
            Storage::disk('public')->delete($leave->attachment_path);
        }

        $leave->delete();

        return redirect()
            ->route('leaves.index')
            ->with('success', 'Pengajuan cuti berhasil dihapus');
    }

    public function approve(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()
                ->route('leaves.show', $leave)
                ->with('error', 'Pengajuan cuti sudah diproses sebelumnya');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'notes' => $validated['notes'],
        ]);

        // TODO: Send email notification to employee

        return redirect()
            ->route('leaves.show', $leave)
            ->with('success', 'Pengajuan cuti berhasil disetujui');
    }

    public function reject(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()
                ->route('leaves.show', $leave)
                ->with('error', 'Pengajuan cuti sudah diproses sebelumnya');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        // TODO: Send email notification to employee

        return redirect()
            ->route('leaves.show', $leave)
            ->with('success', 'Pengajuan cuti berhasil ditolak');
    }
}
