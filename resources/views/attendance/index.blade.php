<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absensi') }}
        </h2>
    </x-slot>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <form action="{{ route('attendance.index') }}" method="GET" class="flex flex-wrap gap-4">
                    <!-- Search Employee -->
                    <div class="flex-1 min-w-[200px]">
                        <label for="employee" class="block text-sm font-medium text-gray-700">Cari Karyawan</label>
                        <input type="text" name="search" id="employee" value="{{ request('search') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Nama atau ID Karyawan">
                    </div>

                    <!-- Date Filter -->
                    <div class="flex-1 min-w-[200px]">
                        <label for="date" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ request('date') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Status Filter -->
                    <div class="flex-1 min-w-[200px]">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Hadir</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Terlambat</option>
                            <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Izin</option>
                            <option value="sick" {{ request('status') == 'sick' ? 'selected' : '' }}>Sakit</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Alpha</option>
                        </select>
                    </div>

                    <!-- Department Filter -->
                    <div class="flex-1 min-w-[200px]">
                        <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                        <select name="department" id="department" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'date', 'status', 'department']))
                            <a href="{{ route('attendance.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Attendance Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Karyawan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam Masuk
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam Keluar
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $attendance->employee->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $attendance->employee->employee_id }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $attendance->date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $attendance->status == 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $attendance->status == 'absent' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $attendance->status == 'leave' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $attendance->status == 'sick' ? 'bg-purple-100 text-purple-800' : '' }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('attendance.show', $attendance) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data absensi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 