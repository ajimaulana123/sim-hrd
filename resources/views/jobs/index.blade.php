@extends('layouts.app')

@section('header')
Daftar Lowongan Kerja
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <!-- Header with Action Button -->
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <p class="mt-2 text-sm text-gray-700">
                    Kelola lowongan pekerjaan yang tersedia.
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('jobs.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Lowongan
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('jobs.index') }}" method="GET">
                    <div class="flex flex-wrap items-end gap-4">
                        <!-- Search -->
                        <div class="w-full sm:w-44">
                            <x-input-label for="search" :value="__('Cari Lowongan')" />
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" 
                                :value="request('search')" placeholder="Judul, Departemen, Posisi"/>
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

                        <!-- Employment Type Filter -->
                        <div class="w-full sm:w-44">
                            <x-input-label for="employment_type" :value="__('Tipe Pekerjaan')" />
                            <select id="employment_type" name="employment_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Semua Tipe</option>
                                @foreach($employmentTypes as $value => $label)
                                    <option value="{{ $value }}" {{ request('employment_type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="w-full sm:w-36">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Semua Status</option>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
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
                            @if(request()->hasAny(['search', 'department', 'employment_type', 'status']))
                                <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Reset') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Job Vacancies Table -->
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Posisi</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Departemen</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tipe</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Kuota</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Deadline</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Pelamar</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($vacancies as $job)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                        <div class="font-medium text-gray-900">{{ $job->title }}</div>
                                        <div class="text-gray-500">{{ $job->position }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $job->department }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @php
                                        $typeLabels = [
                                        'full_time' => 'Full Time',
                                        'part_time' => 'Part Time',
                                        'contract' => 'Contract',
                                        'internship' => 'Internship'
                                        ];
                                        @endphp
                                        {{ $typeLabels[$job->employment_type] }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $job->quota }} orang</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $job->end_date->format('d F Y') }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @php
                                        $statusClasses = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800'
                                        ];
                                        $statusLabels = [
                                        'active' => 'Aktif',
                                        'inactive' => 'Tidak Aktif'
                                        ];
                                        @endphp
                                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $statusClasses[$job->status] }}">
                                            {{ $statusLabels[$job->status] }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $job->applications_count ?? 0 }} pelamar
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-3 py-4 text-sm text-gray-500 text-center">Tidak ada lowongan kerja</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($vacancies->hasPages())
        <div class="mt-6">
            {{ $vacancies->links() }}
        </div>
        @endif
    </div>
</div>
@endsection