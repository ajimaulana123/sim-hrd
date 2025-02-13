@extends('layouts.app')

@section('header')
Detail Karyawan
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <!-- Header -->
    <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="h-16 w-16 flex-shrink-0">
                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-500">
                        <span class="text-xl font-medium leading-none text-white">{{ substr($employee->name, 0, 1) }}</span>
                    </span>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $employee->name }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $employee->position }} - {{ $employee->department }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
            <button type="button" class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" x-on:click="activeTab = 'personal'" x-bind:class="{ 'border-indigo-500 text-indigo-600': activeTab === 'personal', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'personal' }">Data Pribadi</button>
            <button type="button" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" x-on:click="activeTab = 'employment'" x-bind:class="{ 'border-indigo-500 text-indigo-600': activeTab === 'employment', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'employment' }">Data Kepegawaian</button>
            <button type="button" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" x-on:click="activeTab = 'financial'" x-bind:class="{ 'border-indigo-500 text-indigo-600': activeTab === 'financial', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'financial' }">Data Keuangan</button>
            <button type="button" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" x-on:click="activeTab = 'history'" x-bind:class="{ 'border-indigo-500 text-indigo-600': activeTab === 'history', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'history' }">Riwayat</button>
        </nav>
    </div>

    <!-- Tab Panels -->
    <div class="px-6 py-6">
        <!-- Personal Information -->
        <div x-show="activeTab === 'personal'">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">ID Karyawan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->employee_id }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->email }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->phone }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->address }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->birth_date->format('d F Y') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Employment Information -->
        <div x-show="activeTab === 'employment'" x-cloak>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->department }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->position }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->join_date->format('d F Y') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : ($employee->status === 'probation' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Financial Information -->
        <div x-show="activeTab === 'financial'" x-cloak>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Gaji Pokok</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($employee->base_salary, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Bank</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->bank_name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Nomor Rekening</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->bank_account }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">NPWP</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->npwp }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">BPJS Ketenagakerjaan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->bpjs_tk }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">BPJS Kesehatan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->bpjs_kes }}</dd>
                </div>
            </dl>
        </div>

        <!-- History -->
        <div x-show="activeTab === 'history'" x-cloak>
            <div class="space-y-6">
                <!-- Attendance History -->
                <div>
                    <h4 class="text-base font-medium text-gray-900">Riwayat Kehadiran</h4>
                    <div class="mt-4 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Tanggal</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Clock In</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Clock Out</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($employee->attendances()->latest()->take(5)->get() as $attendance)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{ $attendance->date->format('d F Y') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : ($attendance->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $attendance->clock_in->format('H:i') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payroll History -->
                <div>
                    <h4 class="text-base font-medium text-gray-900">Riwayat Penggajian</h4>
                    <div class="mt-4 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Periode</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Gaji Pokok</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($employee->payrolls()->latest()->take(5)->get() as $payroll)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{ $payroll->month }}/{{ $payroll->year }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $payroll->status === 'paid' ? 'bg-green-100 text-green-800' : ($payroll->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($payroll->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leave History -->
                <div>
                    <h4 class="text-base font-medium text-gray-900">Riwayat Cuti</h4>
                    <div class="mt-4 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Tanggal</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tipe</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Durasi</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($employee->leaves()->latest()->take(5)->get() as $leave)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{ $leave->start_date->format('d F Y') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ ucfirst($leave->type) }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $leave->duration }} hari</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $leave->status === 'approved' ? 'bg-green-100 text-green-800' : ($leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($leave->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('employeeShow', () => ({
            activeTab: 'personal'
        }))
    })
</script>
@endpush
@endsection