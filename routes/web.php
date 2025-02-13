<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\JobVacancy;
use App\Models\Leave;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $totalEmployees = Employee::count();
        $departmentDistribution = Employee::select('department', DB::raw('count(*) as count'))
            ->groupBy('department')
            ->get();

        $presentToday = Attendance::whereDate('clock_in', Carbon::today())
            ->distinct('employee_id')
            ->count('employee_id');

        $activeVacancies = JobVacancy::where('status', 'active')
            ->where('end_date', '>=', now())
            ->count();

        $pendingLeaves = Leave::where('status', 'pending')->count();

        // Gather recent activities
        $recentLeaves = Leave::with('employee')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($leave) {
                return [
                    'type' => 'leave',
                    'date' => $leave->created_at,
                    'description' => $leave->employee->name . ' mengajukan cuti ' . strtolower($leave->type),
                    'status' => $leave->status
                ];
            });

        $recentAttendances = Attendance::with('employee')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($attendance) {
                return [
                    'type' => 'attendance',
                    'date' => $attendance->clock_in,
                    'description' => $attendance->employee->name . ' melakukan ' . ($attendance->clock_out ? 'clock out' : 'clock in'),
                    'status' => 'completed'
                ];
            });

        $recentApplications = JobVacancy::withCount('applications')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($vacancy) {
                return [
                    'type' => 'job',
                    'date' => $vacancy->created_at,
                    'description' => 'Lowongan baru: ' . $vacancy->title . ' (' . $vacancy->applications_count . ' pelamar)',
                    'status' => $vacancy->status
                ];
            });

        $recentActivities = $recentLeaves->concat($recentAttendances)
            ->concat($recentApplications)
            ->sortByDesc('date')
            ->take(10)
            ->values();

        return view('dashboard', compact(
            'totalEmployees',
            'departmentDistribution',
            'presentToday',
            'activeVacancies',
            'pendingLeaves',
            'recentActivities'
        ));
    })->name('dashboard');

    // Karyawan
    Route::resource('employees', EmployeeController::class);

    // Absensi
    Route::resource('attendances', AttendanceController::class);
    Route::post('attendances/clock-in', [AttendanceController::class, 'clockIn'])->name('attendances.clockIn');
    Route::post('attendances/clock-out', [AttendanceController::class, 'clockOut'])->name('attendances.clockOut');

    // Penggajian
    Route::resource('payrolls', PayrollController::class);
    Route::get('payrolls/{payroll}/print', [PayrollController::class, 'print'])->name('payrolls.print');
    Route::post('payrolls/generate', [PayrollController::class, 'generate'])->name('payrolls.generate');

    // Rekrutmen
    Route::resource('jobs', JobVacancyController::class);
    Route::resource('applications', JobApplicationController::class);
    Route::post('applications/{application}/schedule-interview', [JobApplicationController::class, 'scheduleInterview'])
        ->name('applications.scheduleInterview');

    // Cuti
    Route::resource('leaves', LeaveController::class);
    Route::post('leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
