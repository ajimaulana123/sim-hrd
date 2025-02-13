@extends('layouts.app')

@section('header')
Detail Lowongan Kerja
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $job->department }} - {{ $job->position }}</p>
            </div>
            <div class="mt-4 flex sm:mt-0">
                <a href="{{ route('jobs.edit', $job) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="ml-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-red-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Status -->
        <div class="mt-6">
            @php
            $statusClasses = [
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-red-100 text-red-800',
            ];
            $statusLabels = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            ];
            @endphp
            <span class="inline-flex items-center rounded-full px-3 py-0.5 text-sm font-medium {{ $statusClasses[$job->status] }}">
                {{ $statusLabels[$job->status] }}
            </span>
        </div>

        <!-- Basic Information -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">Informasi Dasar</h3>
            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Departemen</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $job->department }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Posisi</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $job->position }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tipe Pekerjaan</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @php
                        $employmentTypes = [
                        'full_time' => 'Full Time',
                        'part_time' => 'Part Time',
                        'contract' => 'Contract',
                        'internship' => 'Internship'
                        ];
                        @endphp
                        {{ $employmentTypes[$job->employment_type] }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kuota</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $job->quota }} orang</dd>
                </div>
            </dl>
        </div>

        <!-- Job Details -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">Detail Pekerjaan</h3>
            <div class="mt-4 space-y-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Deskripsi Pekerjaan</h4>
                    <div class="mt-2 whitespace-pre-wrap text-sm text-gray-500">{{ $job->description }}</div>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Persyaratan</h4>
                    <div class="mt-2 whitespace-pre-wrap text-sm text-gray-500">{{ $job->requirements }}</div>
                </div>
            </div>
        </div>

        <!-- Salary and Schedule -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">Gaji dan Jadwal</h3>
            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Rentang Gaji</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        Rp {{ number_format($job->salary_min, 0, ',', '.') }} - Rp {{ number_format($job->salary_max, 0, ',', '.') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Periode Lamaran</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $job->start_date->format('d F Y') }} - {{ $job->end_date->format('d F Y') }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Applications -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Pelamar</h3>
                    <p class="mt-1 text-sm text-gray-500">Daftar pelamar untuk posisi ini.</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('applications.create', ['job' => $job->id]) }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Tambah Pelamar
                    </a>
                </div>
            </div>

            @if($job->applications->count() > 0)
            <div class="mt-4 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">Nama</th>
                                    <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Email</th>
                                    <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Tanggal Lamaran</th>
                                    <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($job->applications as $application)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 md:pl-0">
                                        {{ $application->name }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        {{ $application->email }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        {{ $application->created_at->format('d F Y') }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        @php
                                        $applicationStatusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'shortlisted' => 'bg-blue-100 text-blue-800',
                                        'interviewed' => 'bg-purple-100 text-purple-800',
                                        'accepted' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $applicationStatusLabels = [
                                        'pending' => 'Pending',
                                        'shortlisted' => 'Shortlisted',
                                        'interviewed' => 'Interviewed',
                                        'accepted' => 'Diterima',
                                        'rejected' => 'Ditolak',
                                        ];
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $applicationStatusClasses[$application->status] }}">
                                            {{ $applicationStatusLabels[$application->status] }}
                                        </span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                        <a href="{{ route('applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Lihat<span class="sr-only">, {{ $application->name }}</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="mt-4 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pelamar</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada yang melamar untuk posisi ini.</p>
            </div>
            @endif
        </div>

        <!-- Additional Information -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <div class="text-sm text-gray-500">
                <p>Dibuat pada: {{ $job->created_at->format('d F Y H:i') }}</p>
                <p>Terakhir diupdate: {{ $job->updated_at->format('d F Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 px-4 py-4 sm:px-6">
        <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
            &larr; Kembali ke daftar lowongan
        </a>
    </div>
</div>
@endsection