@extends('layouts.app')

@section('header')
{{ isset($job) ? 'Edit Lowongan Kerja' : 'Tambah Lowongan Kerja' }}
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <form action="{{ isset($job) ? route('jobs.update', $job) : route('jobs.store') }}" method="POST">
        @csrf
        @if(isset($job))
        @method('PUT')
        @endif

        <div class="px-4 py-5 sm:p-6">
            <!-- Basic Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Dasar</h3>
                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                    <div class="sm:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Lowongan</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $job->title ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                        <select id="department" name="department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Departemen</option>
                            @foreach(['IT', 'HR', 'Finance', 'Marketing', 'Operations'] as $dept)
                            <option value="{{ $dept }}" {{ old('department', $job->department ?? '') == $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                            @endforeach
                        </select>
                        @error('department')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">Posisi</label>
                        <input type="text" name="position" id="position" value="{{ old('position', $job->position ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('position')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employment_type" class="block text-sm font-medium text-gray-700">Tipe Pekerjaan</label>
                        <select id="employment_type" name="employment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Tipe</option>
                            @foreach(['full_time' => 'Full Time', 'part_time' => 'Part Time', 'contract' => 'Contract', 'internship' => 'Internship'] as $value => $label)
                            <option value="{{ $value }}" {{ old('employment_type', $job->employment_type ?? '') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('employment_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quota" class="block text-sm font-medium text-gray-700">Kuota</label>
                        <input type="number" name="quota" id="quota" min="1" value="{{ old('quota', $job->quota ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('quota')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Job Description and Requirements -->
            <div class="mt-6 border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Detail Pekerjaan</h3>
                <p class="mt-1 text-sm text-gray-500">Masukkan detail dan persyaratan pekerjaan.</p>

                <div class="mt-4 grid grid-cols-1 gap-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Pekerjaan</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $job->description ?? '') }}</textarea>
                        </div>
                        @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="requirements" class="block text-sm font-medium text-gray-700">Persyaratan</label>
                        <div class="mt-1">
                            <textarea id="requirements" name="requirements" rows="5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('requirements', $job->requirements ?? '') }}</textarea>
                        </div>
                        @error('requirements')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Salary and Schedule -->
            <div class="mt-6 border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Gaji dan Jadwal</h3>
                <p class="mt-1 text-sm text-gray-500">Masukkan informasi gaji dan jadwal pekerjaan.</p>

                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-gray-700">Gaji Minimum</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min', $job->salary_min ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        @error('salary_min')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-gray-700">Gaji Maximum</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max', $job->salary_max ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        @error('salary_max')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($job) ? $job->start_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('start_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($job) ? $job->end_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('end_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Status Lowongan</h3>
                <div class="mt-4">
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @foreach(['active' => 'Aktif', 'inactive' => 'Tidak Aktif'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $job->status ?? 'active') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
            <a href="{{ route('jobs.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</a>
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ isset($job) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection