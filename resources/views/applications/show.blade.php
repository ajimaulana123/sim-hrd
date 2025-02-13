@extends('layouts.app')

@section('header')
Detail Lamaran
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $application->name }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $application->job->title }}</p>
            </div>
            @if(auth()->user()->is_admin)
            <div class="mt-4 flex sm:mt-0">
                <a href="{{ route('applications.edit', $application) }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('applications.destroy', $application) }}" method="POST" class="ml-3">
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
            @endif
        </div>

        <!-- Status -->
        <div class="mt-6">
            @php
            $statusClasses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'shortlisted' => 'bg-blue-100 text-blue-800',
            'interviewed' => 'bg-purple-100 text-purple-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            ];
            $statusLabels = [
            'pending' => 'Pending',
            'shortlisted' => 'Shortlisted',
            'interviewed' => 'Interviewed',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            ];
            @endphp
            <span class="inline-flex items-center rounded-full px-3 py-0.5 text-sm font-medium {{ $statusClasses[$application->status] }}">
                {{ $statusLabels[$application->status] }}
            </span>
        </div>

        <!-- Basic Information -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">Informasi Dasar</h3>
            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->phone }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Ekspektasi Gaji</dt>
                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($application->expected_salary, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Lamaran</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->created_at->format('d F Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Cover Letter -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">Cover Letter</h3>
            <div class="mt-4 whitespace-pre-wrap text-sm text-gray-500">{{ $application->cover_letter }}</div>
        </div>

        <!-- Documents -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">Dokumen</h3>
            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Resume</dt>
                    <dd class="mt-1">
                        @if($application->resume_path)
                        <a href="{{ Storage::url($application->resume_path) }}" target="_blank" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download Resume
                        </a>
                        @else
                        <span class="text-sm text-gray-500">Tidak ada resume</span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Dokumen Tambahan</dt>
                    <dd class="mt-1">
                        @if($application->additional_documents)
                        <ul class="list-inside list-disc space-y-2">
                            @foreach(json_decode($application->additional_documents) as $document)
                            <li class="text-sm text-gray-500">
                                <a href="{{ Storage::url($document) }}" target="_blank" class="text-indigo-600 hover:text-indigo-500">
                                    {{ basename($document) }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-sm text-gray-500">Tidak ada dokumen tambahan</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        @if(auth()->user()->is_admin)
        <!-- Interview Information -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">Informasi Interview</h3>
            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Interview</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $application->interview_date ? $application->interview_date->format('d F Y H:i') : 'Belum dijadwalkan' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Interviewer</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $application->interviewer ?: 'Belum ditentukan' }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">
                        {{ $application->notes ?: 'Tidak ada catatan' }}
                    </dd>
                </div>
            </dl>
        </div>
        @endif

        <!-- Additional Information -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <div class="text-sm text-gray-500">
                <p>Dibuat pada: {{ $application->created_at->format('d F Y H:i') }}</p>
                <p>Terakhir diupdate: {{ $application->updated_at->format('d F Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 px-4 py-4 sm:px-6">
        <a href="{{ route('applications.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
            &larr; Kembali ke daftar lamaran
        </a>
    </div>
</div>
@endsection