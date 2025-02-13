<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when(request('department'), function ($query, $department) {
                $query->where('department', $department);
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:employees,employee_id',
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'birth_date' => 'required|date',
            'join_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'position' => 'required',
            'department' => 'required',
            'base_salary' => 'required|numeric|min:0|max:999999999',
            'status' => 'required|in:active,inactive,on_leave',
            'bank_name' => 'nullable',
            'bank_account' => 'nullable',
            'tax_id' => 'nullable',
            'bpjs_tk' => 'nullable',
            'bpjs_kes' => 'nullable',
        ]);

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['attendances' => function ($query) {
            $query->latest()->take(5);
        }, 'payrolls' => function ($query) {
            $query->latest()->take(5);
        }, 'leaves' => function ($query) {
            $query->latest()->take(5);
        }]);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.form', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:employees,employee_id,' . $employee->id,
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable',
            'address' => 'nullable',
            'birth_date' => 'required|date',
            'join_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'position' => 'required',
            'department' => 'required',
            'base_salary' => 'required|numeric|min:0|max:999999999',
            'status' => 'required|in:active,inactive,on_leave',
            'bank_name' => 'nullable',
            'bank_account' => 'nullable',
            'tax_id' => 'nullable',
            'bpjs_tk' => 'nullable',
            'bpjs_kes' => 'nullable',
        ]);

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }
}
