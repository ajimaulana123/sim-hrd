@extends('layouts.app')

@section('header')
{{ isset($employee) ? 'Edit Karyawan' : 'Tambah Karyawan Baru' }}
@endsection

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <form action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}" method="POST" class="space-y-8 divide-y divide-gray-200">
        @csrf
        @if(isset($employee))
        @method('PUT')
        @endif

        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button type="button" class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" x-on:click="activeTab = 'personal'" x-bind:class="{ 'border-indigo-500 text-indigo-600': activeTab === 'personal', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'personal' }">Data Pribadi</button>
                <button type="button" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" x-on:click="activeTab = 'employment'" x-bind:class="{ 'border-indigo-500 text-indigo-600': activeTab === 'employment', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'employment' }">Data Kepegawaian</button>
                <button type="button" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" x-on:click="activeTab = 'financial'" x-bind:class="{ 'border-indigo-500 text-indigo-600': activeTab === 'financial', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'financial' }">Data Keuangan</button>
            </nav>
        </div>

        <!-- Tab Panels -->
        <div class="px-6 py-6">
            <!-- Personal Information -->
            <div x-show="activeTab === 'personal'">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="employee_id" class="block text-sm font-medium text-gray-700">ID Karyawan</label>
                        <div class="mt-1">
                            <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $employee->employee_id ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('employee_id') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('employee_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name', $employee->name ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('name') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email', $employee->email ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('email') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <div class="mt-1">
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('phone') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <div class="mt-1">
                            <textarea name="address" id="address" rows="3" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('address') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">{{ old('address', $employee->address ?? '') }}</textarea>
                        </div>
                        @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <div class="mt-1">
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', isset($employee) ? $employee->birth_date->format('Y-m-d') : '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('birth_date') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('birth_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <div class="mt-1">
                            <select name="gender" id="gender" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('gender') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender', $employee->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $employee->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('gender')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div x-show="activeTab === 'employment'" x-cloak>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                        <div class="mt-1">
                            <select name="department" id="department" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('department') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                                <option value="">Pilih Department</option>
                                <option value="IT" {{ old('department', $employee->department ?? '') == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="HR" {{ old('department', $employee->department ?? '') == 'HR' ? 'selected' : '' }}>HR</option>
                                <option value="Finance" {{ old('department', $employee->department ?? '') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Marketing" {{ old('department', $employee->department ?? '') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Operations" {{ old('department', $employee->department ?? '') == 'Operations' ? 'selected' : '' }}>Operations</option>
                            </select>
                        </div>
                        @error('department')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <div class="mt-1">
                            <input type="text" name="position" id="position" value="{{ old('position', $employee->position ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('position') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('position')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="join_date" class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                        <div class="mt-1">
                            <input type="date" name="join_date" id="join_date" value="{{ old('join_date', isset($employee) ? $employee->join_date->format('Y-m-d') : '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('join_date') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('join_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            <select name="status" id="status" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('status') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                                <option value="">Pilih Status</option>
                                <option value="active" {{ old('status', $employee->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="probation" {{ old('status', $employee->status ?? '') == 'probation' ? 'selected' : '' }}>Probation</option>
                                <option value="terminated" {{ old('status', $employee->status ?? '') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>
                        @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Financial Information -->
            <div x-show="activeTab === 'financial'" x-cloak>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="base_salary" class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                        <div class="mt-1">
                            <input type="number" name="base_salary" id="base_salary" value="{{ old('base_salary', $employee->base_salary ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('base_salary') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('base_salary')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="bank_name" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                        <div class="mt-1">
                            <select name="bank_name" id="bank_name" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('bank_name') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                                <option value="">Pilih Bank</option>
                                <option value="BCA" {{ old('bank_name', $employee->bank_name ?? '') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                <option value="Mandiri" {{ old('bank_name', $employee->bank_name ?? '') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="BNI" {{ old('bank_name', $employee->bank_name ?? '') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                <option value="BRI" {{ old('bank_name', $employee->bank_name ?? '') == 'BRI' ? 'selected' : '' }}>BRI</option>
                            </select>
                        </div>
                        @error('bank_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="bank_account" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                        <div class="mt-1">
                            <input type="text" name="bank_account" id="bank_account" value="{{ old('bank_account', $employee->bank_account ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('bank_account') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('bank_account')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="npwp" class="block text-sm font-medium text-gray-700">NPWP</label>
                        <div class="mt-1">
                            <input type="text" name="npwp" id="npwp" value="{{ old('npwp', $employee->npwp ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('npwp') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('npwp')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="bpjs_tk" class="block text-sm font-medium text-gray-700">BPJS Ketenagakerjaan</label>
                        <div class="mt-1">
                            <input type="text" name="bpjs_tk" id="bpjs_tk" value="{{ old('bpjs_tk', $employee->bpjs_tk ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('bpjs_tk') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('bpjs_tk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="bpjs_kes" class="block text-sm font-medium text-gray-700">BPJS Kesehatan</label>
                        <div class="mt-1">
                            <input type="text" name="bpjs_kes" id="bpjs_kes" value="{{ old('bpjs_kes', $employee->bpjs_kes ?? '') }}" class="block w-full rounded-md shadow-sm sm:text-sm {{ $errors->has('bpjs_kes') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>
                        @error('bpjs_kes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex items-center justify-end space-x-3">
            <a href="{{ route('employees.index') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</a>
            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ isset($employee) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('employeeForm', () => ({
            activeTab: 'personal'
        }))
    })
</script>
@endpush
@endsection