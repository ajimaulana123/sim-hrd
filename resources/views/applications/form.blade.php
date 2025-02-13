@extends('layouts.app')

@section('header')
{{ isset($application) ? 'Edit Lamaran' : 'Tambah Lamaran' }}
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <form action="{{ isset($application) ? route('applications.update', $application) : route('applications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($application))
        @method('PUT')
        @endif

        <div class="px-4 py-5 sm:p-6">
            <!-- Job Vacancy Selection -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Lowongan Kerja</h3>
                <div class="mt-4">
                    <select id="job_vacancy_id" name="job_vacancy_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Pilih Lowongan</option>
                        @foreach($jobs as $job)
                        <option value="{{ $job->id }}" {{ old('job_vacancy_id', $application->job_vacancy_id ?? request('job')) == $job->id ? 'selected' : '' }}>
                            {{ $job->title }} ({{ $job->department }})
                        </option>
                        @endforeach
                    </select>
                    @error('job_vacancy_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Personal Information -->
            <div class="mt-6 border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Pribadi</h3>
                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $application->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $application->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $application->phone ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover Letter</label>
                        <div class="mt-1">
                            <textarea id="cover_letter" name="cover_letter" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('cover_letter', $application->cover_letter ?? '') }}</textarea>
                        </div>
                        @error('cover_letter')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expected_salary" class="block text-sm font-medium text-gray-700">Ekspektasi Gaji</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="expected_salary" id="expected_salary" value="{{ old('expected_salary', $application->expected_salary ?? '') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        @error('expected_salary')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="mt-6 border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Dokumen</h3>
                <div class="mt-4 space-y-6">
                    <div>
                        <label for="resume" class="block text-sm font-medium text-gray-700">Resume</label>
                        <div class="mt-1">
                            <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        @if(isset($application) && $application->resume_path)
                        <p class="mt-2 text-sm text-gray-500">File saat ini: {{ basename($application->resume_path) }}</p>
                        @endif
                        @error('resume')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="additional_documents" class="block text-sm font-medium text-gray-700">Dokumen Tambahan</label>
                        <div class="mt-1">
                            <input type="file" name="additional_documents[]" id="additional_documents" accept=".pdf,.doc,.docx" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        @if(isset($application) && $application->additional_documents)
                        <div class="mt-2">
                            <p class="text-sm font-medium text-gray-700">Dokumen saat ini:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-gray-500">
                                @foreach(json_decode($application->additional_documents) as $document)
                                <li>{{ basename($document) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @error('additional_documents')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Anda dapat mengunggah beberapa file (sertifikat, portofolio, dll).</p>
                    </div>
                </div>
            </div>

            @if(auth()->user()->is_admin)
            <!-- Admin Section -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Status Lamaran</h3>
                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach(['pending' => 'Pending', 'shortlisted' => 'Shortlisted', 'interviewed' => 'Interviewed', 'accepted' => 'Diterima', 'rejected' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $application->status ?? 'pending') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="interview_date" class="block text-sm font-medium text-gray-700">Tanggal Interview</label>
                        <input type="datetime-local" name="interview_date" id="interview_date" value="{{ old('interview_date', isset($application) && $application->interview_date ? $application->interview_date->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('interview_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="interviewer" class="block text-sm font-medium text-gray-700">Interviewer</label>
                        <input type="text" name="interviewer" id="interviewer" value="{{ old('interviewer', $application->interviewer ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('interviewer')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                        <div class="mt-1">
                            <textarea id="notes" name="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('notes', $application->notes ?? '') }}</textarea>
                        </div>
                        @error('notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
            <a href="{{ route('applications.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</a>
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ isset($application) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection