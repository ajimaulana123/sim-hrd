<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        // Filter by employee name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('department', $request->department);
            });
        }

        $attendances = $query->latest()->paginate(10)->withQueryString();
        $departments = Employee::select('department')->distinct()->pluck('department');

        return view('attendances.index', compact('attendances', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::active()->get();
        return view('attendances.form', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'status' => 'required|in:present,absent,late,leave,sick',
            'notes' => 'nullable|string',
            'location_in' => 'nullable|string',
            'location_out' => 'nullable|string',
        ]);

        Attendance::create($validated + [
            'ip_address' => $request->ip(),
            'device' => $request->userAgent(),
        ]);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Data absensi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $employees = Employee::active()->get();
        return view('attendances.form', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'status' => 'required|in:present,absent,late,leave,sick',
            'notes' => 'nullable|string',
            'location_in' => 'nullable|string',
            'location_out' => 'nullable|string',
        ]);

        $attendance->update($validated);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Data absensi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Data absensi berhasil dihapus');
    }

    public function clockIn(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'location_in' => 'nullable|string',
        ]);

        $attendance = Attendance::create([
            'employee_id' => $validated['employee_id'],
            'date' => now()->toDateString(),
            'clock_in' => now()->format('H:i'),
            'status' => now()->format('H:i') > '08:00' ? 'late' : 'present',
            'location_in' => $validated['location_in'],
            'ip_address' => $request->ip(),
            'device' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Berhasil clock in',
            'data' => $attendance
        ]);
    }

    public function clockOut(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'location_out' => 'nullable|string',
        ]);

        $attendance = Attendance::where('employee_id', $validated['employee_id'])
            ->whereDate('date', now())
            ->firstOrFail();

        $attendance->update([
            'clock_out' => now()->format('H:i'),
            'location_out' => $validated['location_out'],
        ]);

        return response()->json([
            'message' => 'Berhasil clock out',
            'data' => $attendance
        ]);
    }
}
