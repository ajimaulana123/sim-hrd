<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->when(request('month'), function ($query, $month) {
                $query->where('month', $month);
            })
            ->when(request('year'), function ($query, $year) {
                $query->where('year', $year);
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('payrolls.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::active()->get();
        return view('payrolls.form', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string',
            'year' => 'required|integer',
            'base_salary' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'overtime_pay' => 'nullable|numeric',
            'bonus' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'bpjs_tk' => 'nullable|numeric',
            'bpjs_kes' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,approved,paid',
            'payment_date' => 'nullable|date',
        ]);

        // Hitung gaji bersih
        $net_salary = $validated['base_salary']
            + ($validated['allowances'] ?? 0)
            + ($validated['overtime_pay'] ?? 0)
            + ($validated['bonus'] ?? 0)
            - ($validated['deductions'] ?? 0)
            - ($validated['tax'] ?? 0)
            - ($validated['bpjs_tk'] ?? 0)
            - ($validated['bpjs_kes'] ?? 0);

        Payroll::create($validated + ['net_salary' => $net_salary]);

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Data penggajian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        return view('payrolls.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        $employees = Employee::active()->get();
        return view('payrolls.form', compact('payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string',
            'year' => 'required|integer',
            'base_salary' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'overtime_pay' => 'nullable|numeric',
            'bonus' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'bpjs_tk' => 'nullable|numeric',
            'bpjs_kes' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,approved,paid',
            'payment_date' => 'nullable|date',
        ]);

        // Hitung gaji bersih
        $net_salary = $validated['base_salary']
            + ($validated['allowances'] ?? 0)
            + ($validated['overtime_pay'] ?? 0)
            + ($validated['bonus'] ?? 0)
            - ($validated['deductions'] ?? 0)
            - ($validated['tax'] ?? 0)
            - ($validated['bpjs_tk'] ?? 0)
            - ($validated['bpjs_kes'] ?? 0);

        $payroll->update($validated + ['net_salary' => $net_salary]);

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Data penggajian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Data penggajian berhasil dihapus');
    }

    public function print(Payroll $payroll)
    {
        $pdf = PDF::loadView('payrolls.print', compact('payroll'));
        return $pdf->download('slip-gaji-' . $payroll->employee->name . '-' . $payroll->month . '-' . $payroll->year . '.pdf');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|string',
            'year' => 'required|integer',
        ]);

        $employees = Employee::active()->get();

        foreach ($employees as $employee) {
            // Hitung overtime dari absensi
            $overtime_hours = $employee->attendances()
                ->whereYear('date', $validated['year'])
                ->whereMonth('date', $validated['month'])
                ->sum('overtime_hours');

            $overtime_pay = $overtime_hours * ($employee->base_salary / 173);

            // Hitung potongan dari ketidakhadiran
            $absences = $employee->attendances()
                ->whereYear('date', $validated['year'])
                ->whereMonth('date', $validated['month'])
                ->where('status', 'absent')
                ->count();

            $deductions = $absences * ($employee->base_salary / 22);

            // Hitung BPJS
            $bpjs_tk = $employee->base_salary * 0.054; // 5.4% dari gaji pokok
            $bpjs_kes = $employee->base_salary * 0.01; // 1% dari gaji pokok

            // Hitung pajak (contoh sederhana)
            $tax = $employee->base_salary * 0.05; // 5% dari gaji pokok

            Payroll::create([
                'employee_id' => $employee->id,
                'month' => $validated['month'],
                'year' => $validated['year'],
                'base_salary' => $employee->base_salary,
                'overtime_pay' => $overtime_pay,
                'deductions' => $deductions,
                'bpjs_tk' => $bpjs_tk,
                'bpjs_kes' => $bpjs_kes,
                'tax' => $tax,
                'net_salary' => $employee->base_salary + $overtime_pay - $deductions - $bpjs_tk - $bpjs_kes - $tax,
                'status' => 'draft',
            ]);
        }

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Data penggajian berhasil digenerate untuk ' . count($employees) . ' karyawan');
    }
}
