@extends('layouts.app')

@section('header')
Daftar Kehadiran
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <!-- Header -->
    <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
        <div class="flex flex-wrap items-center justify-between sm:flex-nowrap">
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">Daftar Kehadiran</h3>
                <p class="mt-1 text-sm text-gray-500">Kelola data kehadiran karyawan</p>
            </div>
            <div class="ml-4 mt-4 flex-shrink-0">
                <a href="{{ route('attendances.create') }}" class="relative inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Tambah Kehadiran
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="border-b border-gray-200 bg-gray-50 px-4 py-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-1 items-center space-x-4">
                <div class="w-full sm:max-w-xs">
                    <label for="search" class="sr-only">Cari</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Cari karyawan...">
                    </div>
                </div>
                <div class="w-full sm:max-w-xs">
                    <select name="date" id="date" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="">Pilih Tanggal</option>
                        <option value="today">Hari Ini</option>
                        <option value="yesterday">Kemarin</option>
                        <option value="this_week">Minggu Ini</option>
                        <option value="last_week">Minggu Lalu</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="last_month">Bulan Lalu</option>
                    </select>
                </div>
                <div class="w-full sm:max-w-xs">
                    <select name="status" id="status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="">Semua Status</option>
                        <option value="present">Hadir</option>
                        <option value="late">Terlambat</option>
                        <option value="absent">Tidak Hadir</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 sm:mt-0">
                <button type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filter
                </button>
            </div>
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
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Clock In</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Clock Out</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Lokasi</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($attendances as $attendance)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500">
                                            <span class="font-medium leading-none text-white">{{ substr($attendance->employee->name, 0, 1) }}</span>
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $attendance->employee->name }}</div>
                                        <div class="text-gray-500">{{ $attendance->employee->employee_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $attendance->date->format('d F Y') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $attendance->clock_in->format('H:i') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : ($attendance->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $attendance->location_in }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('attendances.show', $attendance) }}" class="text-blue-600 hover:text-blue-900">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('attendances.edit', $attendance) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" class="inline-block">
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
                            <td colspan="7" class="px-3 py-4 text-sm text-gray-500 text-center">Tidak ada data kehadiran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
        {{ $attendances->links() }}
    </div>
</div>
@endsection