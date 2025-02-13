@extends('layouts.app')

@section('header')
{{ isset($leave) ? 'Edit Pengajuan Cuti' : 'Ajukan Cuti' }}
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <form action="{{ isset($leave) ? route('leaves.update', $leave) : route('leaves.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($leave))
        @method('PUT')
        @endif

        <div class="px-4 py-5 sm:p-6">
            <!-- Employee Selection -->
            @if(auth()->user()->is_admin)
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Karyawan</h3>
                <div class="mt-4">
                    <select id="employee_id" name="employee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Pilih Karyawan</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id', $leave->employee_id ?? '') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }} ({{ $employee->department }})
                        </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @else
                @if(auth()->user()->employee)
                    <input type="hidden" name="employee_id" value="{{ auth()->user()->employee->id }}">
                @else
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Data Karyawan Tidak Ditemukan</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Anda belum terdaftar sebagai karyawan. Silakan hubungi admin untuk mendaftarkan data karyawan Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('leaves.index') }}" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Kembali</a>
                    </div>
                @endif
            @endif

            <!-- Leave Details -->
            <div class="mt-6 border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900">Detail Cuti</h3>
                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe Cuti</label>
                        <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Tipe</option>
                            @foreach(['annual' => 'Tahunan', 'sick' => 'Sakit', 'maternity' => 'Melahirkan', 'paternity' => 'Cuti Ayah', 'unpaid' => 'Cuti Tanpa Gaji'] as $value => $label)
                            <option value="{{ $value }}" {{ old('type', $leave->type ?? '') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($leave) ? $leave->start_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('start_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($leave) ? $leave->end_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('end_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Alasan</label>
                        <div class="mt-1">
                            <textarea id="reason" name="reason" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('reason', $leave->reason ?? '') }}</textarea>
                        </div>
                        @error('reason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="attachment" class="block text-sm font-medium text-gray-700">Lampiran</label>
                        <div class="mt-1">
                            <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        @if(isset($leave) && $leave->attachment_path)
                        <p class="mt-2 text-sm text-gray-500">File saat ini: {{ basename($leave->attachment_path) }}</p>
                        @endif
                        @error('attachment')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Upload dokumen pendukung (surat dokter, undangan, dll).</p>
                    </div>
                </div>
            </div>

            @if(auth()->user()->is_admin)
            <!-- Approval Section -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Status Persetujuan</h3>
                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach(['pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $leave->status ?? 'pending') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2" x-data="{ showRejectionReason: {{ old('status', $leave->status ?? '') === 'rejected' ? 'true' : 'false' }} }" x-show="showRejectionReason">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                        <div class="mt-1">
                            <textarea id="rejection_reason" name="rejection_reason" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('rejection_reason', $leave->rejection_reason ?? '') }}</textarea>
                        </div>
                        @error('rejection_reason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
            <a href="{{ route('leaves.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</a>
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ isset($leave) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('leaveForm', () => ({
            showRejectionReason: false,
            init() {
                this.$watch('status', value => {
                    this.showRejectionReason = value === 'rejected';
                });
            }
        }));
    });
</script>
@endpush

@endsection