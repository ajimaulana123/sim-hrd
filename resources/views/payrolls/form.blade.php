@extends('layouts.app')

@section('header')
{{ isset($payroll) ? 'Edit Penggajian' : 'Tambah Penggajian' }}
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <form action="{{ isset($payroll) ? route('payrolls.update', $payroll) : route('payrolls.store') }}" method="POST" class="space-y-8 divide-y divide-gray-200">
        @csrf
        @if(isset($payroll))
        @method('PUT')
        @endif

        <div class="space-y-8 divide-y divide-gray-200 px-4 py-5 sm:p-6">
            <!-- Basic Information -->
            <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Penggajian</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Masukkan informasi penggajian karyawan.</p>
                </div>

                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Karyawan</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <select name="employee_id" id="employee_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Pilih Karyawan</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id ?? '') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->employee_id }})
                                </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="period" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Periode</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input type="month" 
                                   id="period" 
                                   name="period" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   value="{{ old('period', isset($payroll) ? $payroll->period->format('Y-m') : '') }}"
                                   required>
                            @error('period')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="base_salary" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Gaji Pokok</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="base_salary" id="base_salary" value="{{ old('base_salary', $payroll->base_salary ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('base_salary')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="allowances" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Tunjangan</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="allowances" id="allowances" value="{{ old('allowances', $payroll->allowances ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('allowances')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="deductions" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Potongan</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="deductions" id="deductions" value="{{ old('deductions', $payroll->deductions ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('deductions')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="overtime_pay" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Lembur</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="overtime_pay" id="overtime_pay" value="{{ old('overtime_pay', $payroll->overtime_pay ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('overtime_pay')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="bonus" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Bonus</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="bonus" id="bonus" value="{{ old('bonus', $payroll->bonus ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('bonus')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="tax" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Pajak</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="tax" id="tax" value="{{ old('tax', $payroll->tax ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('tax')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="bpjs_tk" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">BPJS TK</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="bpjs_tk" id="bpjs_tk" value="{{ old('bpjs_tk', $payroll->bpjs_tk ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('bpjs_tk')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="bpjs_kes" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">BPJS Kesehatan</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="bpjs_kes" id="bpjs_kes" value="{{ old('bpjs_kes', $payroll->bpjs_kes ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error('bpjs_kes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="status" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Status</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Pilih Status</option>
                                <option value="pending" {{ old('status', $payroll->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $payroll->status ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="paid" {{ old('status', $payroll->status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Tanggal Pembayaran</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', isset($payroll) && $payroll->payment_date ? $payroll->payment_date->format('Y-m-d') : '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('payment_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="notes" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Catatan</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('notes', $payroll->notes ?? '') }}</textarea>
                            @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a href="{{ route('payrolls.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</a>
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ isset($payroll) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection