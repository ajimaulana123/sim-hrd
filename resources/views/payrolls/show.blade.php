@extends('layouts.app')

@section('header')
Detail Penggajian
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <!-- Header with Actions -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Slip Gaji - {{ $payroll->employee->name }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Periode: {{ \Carbon\Carbon::createFromFormat('m', $payroll->month)->format('F') }} {{ $payroll->year }}
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('payrolls.edit', $payroll) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit
                </a>
                <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" class="inline-block ml-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Hapus
                    </button>
                </form>
                <a href="{{ route('payrolls.print', $payroll) }}" target="_blank" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cetak Slip
                </a>
            </div>
        </div>

        <!-- Employee Information -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">ID Karyawan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payroll->employee->employee_id }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Nama Karyawan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payroll->employee->name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Departemen</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payroll->employee->department }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Posisi</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payroll->employee->position }}</dd>
                </div>
            </dl>
        </div>

        <!-- Salary Information -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <h4 class="text-base font-medium text-gray-900 mb-4">Informasi Gaji</h4>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Gaji Pokok</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Tunjangan</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->allowances, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Lembur</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->overtime_pay, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Bonus</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->bonus, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Deductions -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <h4 class="text-base font-medium text-gray-900 mb-4">Potongan</h4>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Potongan</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Pajak</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->tax, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">BPJS TK</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->bpjs_tk, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">BPJS Kesehatan</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($payroll->bpjs_kes, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Total -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Total Pendapatan</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">
                        Rp {{ number_format($payroll->base_salary + $payroll->allowances + $payroll->overtime_pay + $payroll->bonus, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Total Potongan</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">
                        Rp {{ number_format($payroll->deductions + $payroll->tax + $payroll->bpjs_tk + $payroll->bpjs_kes, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-base font-medium text-gray-900">Gaji Bersih</dt>
                    <dd class="mt-1 text-xl font-bold text-indigo-600">
                        Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Additional Information -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        @if($payroll->status == 'pending')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                            Pending
                        </span>
                        @elseif($payroll->status == 'approved')
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                            Approved
                        </span>
                        @elseif($payroll->status == 'paid')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                            Paid
                        </span>
                        @endif
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Pembayaran</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $payroll->payment_date ? $payroll->payment_date->format('d/m/Y') : '-' }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payroll->notes ?? '-' }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Dibuat pada</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payroll->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Terakhir diupdate</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payroll->updated_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Back Button -->
    <div class="bg-gray-50 px-4 py-3 sm:px-6">
        <div class="flex justify-start">
            <a href="{{ route('payrolls.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection