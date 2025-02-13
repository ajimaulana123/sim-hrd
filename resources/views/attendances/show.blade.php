@extends('layouts.app')

@section('header')
Detail Kehadiran
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <!-- Header -->
    <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="h-16 w-16 flex-shrink-0">
                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-500">
                        <span class="text-xl font-medium leading-none text-white">{{ substr($attendance->employee->name, 0, 1) }}</span>
                    </span>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $attendance->employee->name }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $attendance->employee->position }} - {{ $attendance->employee->department }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('attendances.edit', $attendance) }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" class="inline-block">
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

    <!-- Content -->
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->date->format('d F Y') }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : ($attendance->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Jam Masuk</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->clock_in->format('H:i') }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Jam Keluar</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Durasi Kerja</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    @if($attendance->clock_out)
                    {{ $attendance->clock_in->diffInHours($attendance->clock_out) }} jam
                    {{ $attendance->clock_in->diffInMinutes($attendance->clock_out) % 60 }} menit
                    @else
                    -
                    @endif
                </dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Lokasi Masuk</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->location_in ?? '-' }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Lokasi Keluar</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->location_out ?? '-' }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->ip_address ?? '-' }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Device</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->device ?? '-' }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->notes ?? '-' }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Dibuat pada</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->created_at->format('d F Y H:i') }}</dd>
            </div>

            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Terakhir diupdate</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $attendance->updated_at->format('d F Y H:i') }}</dd>
            </div>
        </dl>
    </div>

    <!-- Back Button -->
    <div class="bg-gray-50 px-4 py-4 sm:px-6">
        <div class="flex justify-start">
            <a href="{{ route('attendances.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection