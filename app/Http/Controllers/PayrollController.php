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
    public function index(Request $request)
    {
        try {
            $query = Payroll::with('employee');

            // Filter by employee name or ID
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('employee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('employee_id', 'like', "%{$search}%");
                });
            }

            // Filter by period
            if ($request->filled('period')) {
                $period = $request->period;
                $year = substr($period, 0, 4);
                $month = substr($period, 5, 2);
                $query->where('year', $year)
                      ->where('month', $month);
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

            $payrolls = $query->latest()->paginate(10)->withQueryString();
            $departments = Employee::select('department')->distinct()->pluck('department');

            return view('payrolls.index', compact('payrolls', 'departments'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        try {
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'period' => 'required|date_format:Y-m',
                'base_salary' => 'required|numeric|min:0',
                'allowances' => 'nullable|numeric|min:0',
                'deductions' => 'nullable|numeric|min:0',
                'overtime_pay' => 'nullable|numeric|min:0',
                'bonus' => 'nullable|numeric|min:0',
                'tax' => 'nullable|numeric|min:0',
                'bpjs_tk' => 'nullable|numeric|min:0',
                'bpjs_kes' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
                'status' => 'required|in:draft,approved,paid',
                'payment_date' => 'nullable|date',
            ]);

            // Ambil bulan dan tahun dari input period
            $month = date('m', strtotime($validated['period']));
            $year = date('Y', strtotime($validated['period']));

            // Cek duplikasi data
            $exists = Payroll::where('employee_id', $validated['employee_id'])
                ->where('month', $month)
                ->where('year', $year)
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->with('error', 'Data penggajian untuk karyawan ini pada periode tersebut sudah ada');
            }

            // Set nilai default untuk field yang nullable
            $validated['allowances'] = $validated['allowances'] ?? 0;
            $validated['deductions'] = $validated['deductions'] ?? 0;
            $validated['overtime_pay'] = $validated['overtime_pay'] ?? 0;
            $validated['bonus'] = $validated['bonus'] ?? 0;
            $validated['tax'] = $validated['tax'] ?? 0;
            $validated['bpjs_tk'] = $validated['bpjs_tk'] ?? 0;
            $validated['bpjs_kes'] = $validated['bpjs_kes'] ?? 0;

            // Hitung gaji bersih
            $net_salary = $validated['base_salary']
                + $validated['allowances']
                + $validated['overtime_pay']
                + $validated['bonus']
                - $validated['deductions']
                - $validated['tax']
                - $validated['bpjs_tk']
                - $validated['bpjs_kes'];

            // Simpan data dengan month dan year terpisah
            Payroll::create([
                'employee_id' => $validated['employee_id'],
                'month' => $month,
                'year' => $year,
                'base_salary' => $validated['base_salary'],
                'allowances' => $validated['allowances'],
                'deductions' => $validated['deductions'],
                'overtime_pay' => $validated['overtime_pay'],
                'bonus' => $validated['bonus'],
                'tax' => $validated['tax'],
                'bpjs_tk' => $validated['bpjs_tk'],
                'bpjs_kes' => $validated['bpjs_kes'],
                'net_salary' => $net_salary,
                'notes' => $validated['notes'],
                'status' => $validated['status'],
                'payment_date' => $validated['payment_date'],
            ]);

            return redirect()
                ->route('payrolls.index')
                ->with('success', 'Data penggajian berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            'period' => 'required|date',
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
        return $pdf->download('slip-gaji-' . $payroll->employee->name . '-' . $payroll->period->format('M-Y') . '.pdf');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'period' => 'required|date',
        ]);

        $period = $validated['period'];
        $employees = Employee::active()->get();

        foreach ($employees as $employee) {
            // Hitung overtime dari absensi
            $overtime_hours = $employee->attendances()
                ->whereYear('date', date('Y', strtotime($period)))
                ->whereMonth('date', date('m', strtotime($period)))
                ->sum('overtime_hours');

            $overtime_pay = $overtime_hours * ($employee->base_salary / 173);

            // Hitung potongan dari ketidakhadiran
            $absences = $employee->attendances()
                ->whereYear('date', date('Y', strtotime($period)))
                ->whereMonth('date', date('m', strtotime($period)))
                ->where('status', 'absent')
                ->count();

            $deductions = $absences * ($employee->base_salary / 22);

            // Hitung BPJS
            $bpjs_tk = $employee->base_salary * 0.054;
            $bpjs_kes = $employee->base_salary * 0.01;

            // Hitung pajak
            $tax = $employee->base_salary * 0.05;

            Payroll::create([
                'employee_id' => $employee->id,
                'period' => $period,
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
