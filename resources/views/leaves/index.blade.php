@extends('layouts.app')

@section('header')
Daftar Pengajuan Cuti
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Daftar Pengajuan Cuti</h3>
                <p class="mt-1 text-sm text-gray-500">Kelola pengajuan cuti karyawan.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('leaves.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Ajukan Cuti
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-6">
            <form action="{{ route('leaves.index') }}" method="GET" class="grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari</label>
                    <div class="mt-1">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama karyawan..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Semua Status</option>
                        @foreach(['pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Cuti</label>
                    <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Semua Tipe</option>
                        @foreach(['annual' => 'Tahunan', 'sick' => 'Sakit', 'maternity' => 'Melahirkan', 'paternity' => 'Cuti Ayah', 'marriage' => 'Menikah', 'unpaid' => 'Tanpa Bayaran', 'important_reason' => 'Alasan Penting', 'other' => 'Lainnya'] as $value => $label)
                        <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Leave Requests Table -->
        <div class="mt-6">
            <div class="flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">Karyawan</th>
                                    <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Tipe Cuti</th>
                                    <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                    <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Durasi</th>
                                    <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($leaves as $leave)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
                                        <div class="font-medium text-gray-900">{{ $leave->employee->name }}</div>
                                        <div class="text-gray-500">{{ $leave->employee->department }}</div>
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        @php
                                        $typeLabels = [
                                        'annual' => 'Tahunan',
                                        'sick' => 'Sakit',
                                        'maternity' => 'Melahirkan',
                                        'paternity' => 'Cuti Ayah',
                                        'marriage' => 'Menikah',
                                        'unpaid' => 'Tanpa Bayaran',
                                        'important_reason' => 'Alasan Penting',
                                        'other' => 'Lainnya'
                                        ];
                                        @endphp
                                        {{ $typeLabels[$leave->type] }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        {{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        {{ $leave->duration }} hari
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm">
                                        @php
                                        $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusLabels = [
                                        'pending' => 'Pending',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        ];
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusClasses[$leave->status] }}">
                                            {{ $statusLabels[$leave->status] }}
                                        </span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                        <a href="{{ route('leaves.show', $leave) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Lihat<span class="sr-only">, {{ $leave->employee->name }}</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengajuan cuti</h3>
                                            <p class="mt-1 text-sm text-gray-500">Belum ada pengajuan cuti yang tercatat.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($leaves->hasPages())
        <div class="mt-6">
            {{ $leaves->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection