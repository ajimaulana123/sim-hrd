@extends('layouts.app')

@section('header')
{{ isset($attendance) ? 'Edit Kehadiran' : 'Tambah Kehadiran' }}
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <form action="{{ isset($attendance) ? route('attendances.update', $attendance) : route('attendances.store') }}" method="POST" class="space-y-8 divide-y divide-gray-200">
        @csrf
        @if(isset($attendance))
        @method('PUT')
        @endif

        <div class="space-y-8 divide-y divide-gray-200 px-4 py-5 sm:p-6">
            <!-- Basic Information -->
            <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Kehadiran</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Masukkan informasi kehadiran karyawan.</p>
                </div>

                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Karyawan</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <select name="employee_id" id="employee_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Pilih Karyawan</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $attendance->employee_id ?? '') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->employee_id }})
                                </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Tanggal</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input type="date" name="date" id="date" value="{{ old('date', isset($attendance) ? $attendance->date->format('Y-m-d') : '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="clock_in" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Jam Masuk</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input type="time" name="clock_in" id="clock_in" value="{{ old('clock_in', isset($attendance) ? $attendance->clock_in->format('H:i') : '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('clock_in')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="clock_out" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Jam Keluar</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input type="time" name="clock_out" id="clock_out" value="{{ old('clock_out', isset($attendance) && $attendance->clock_out ? $attendance->clock_out->format('H:i') : '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('clock_out')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="status" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Status</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Pilih Status</option>
                                <option value="present" {{ old('status', $attendance->status ?? '') == 'present' ? 'selected' : '' }}>Hadir</option>
                                <option value="late" {{ old('status', $attendance->status ?? '') == 'late' ? 'selected' : '' }}>Terlambat</option>
                                <option value="absent" {{ old('status', $attendance->status ?? '') == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                            </select>
                            @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="location_in" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Lokasi Masuk</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input type="text" name="location_in" id="location_in" value="{{ old('location_in', $attendance->location_in ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('location_in')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="location_out" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Lokasi Keluar</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input type="text" name="location_out" id="location_out" value="{{ old('location_out', $attendance->location_out ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('location_out')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="notes" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Catatan</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('notes', $attendance->notes ?? '') }}</textarea>
                            @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a href="{{ route('attendances.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</a>
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ isset($attendance) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection