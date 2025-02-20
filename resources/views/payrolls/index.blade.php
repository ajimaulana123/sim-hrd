@extends('layouts.app')

@section('header')
Daftar Penggajian
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <!-- Header -->
    <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
        <div class="flex flex-wrap items-center justify-between sm:flex-nowrap">
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">Daftar Penggajian</h3>
                <p class="mt-1 text-sm text-gray-500">Kelola data penggajian karyawan</p>
            </div>
            <div class="ml-4 mt-4 flex-shrink-0">
                <a href="{{ route('payrolls.create') }}" class="relative inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Tambah Penggajian
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('payrolls.index') }}" method="GET">
                <div class="flex flex-wrap items-end gap-4">
                    <!-- Search -->
                    <div class="w-full sm:w-44">
                        <x-input-label for="search" :value="__('Cari Karyawan')" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" 
                            :value="request('search')" placeholder="Nama atau ID"/>
                    </div>

                    <!-- Period Filter -->
                    <div class="w-full sm:w-44">
                        <x-input-label for="period" :value="__('Periode')" />
                        <input type="month" id="period" name="period" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ request('period') }}"
                               placeholder="YYYY-MM">
                    </div>

                    <!-- Status Filter -->
                    <div class="w-full sm:w-36">
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <!-- Department Filter -->
                    <div class="w-full sm:w-44">
                        <x-input-label for="department" :value="__('Departemen')" />
                        <select id="department" name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Filter') }}
                        </button>
                        @if(request()->hasAny(['search', 'period', 'status', 'department']))
                            <a href="{{ route('payrolls.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Reset') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Karyawan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Periode</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Gaji Pokok</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tunjangan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Potongan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($payrolls as $payroll)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500">
                                            <span class="font-medium leading-none text-white">{{ substr($payroll->employee->name, 0, 1) }}</span>
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $payroll->employee->name }}</div>
                                        <div class="text-gray-500">{{ $payroll->employee->employee_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @php
                                    $monthNames = [
                                        '01' => 'Januari',
                                        '02' => 'Februari',
                                        '03' => 'Maret',
                                        '04' => 'April',
                                        '05' => 'Mei',
                                        '06' => 'Juni',
                                        '07' => 'Juli',
                                        '08' => 'Agustus',
                                        '09' => 'September',
                                        '10' => 'Oktober',
                                        '11' => 'November',
                                        '12' => 'Desember'
                                    ];
                                @endphp
                                {{ $monthNames[$payroll->month] ?? '' }} {{ $payroll->year }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Rp {{ number_format($payroll->allowances, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $payroll->status === 'paid' ? 'bg-green-100 text-green-800' : ($payroll->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($payroll->status) }}
                                </span>
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('payrolls.show', $payroll) }}" class="text-blue-600 hover:text-blue-900">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('payrolls.edit', $payroll) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-3 py-4 text-sm text-gray-500 text-center">Tidak ada data penggajian</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection