@extends('layouts.app')

@section('header')
Dashboard
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Total Employees Card -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Employees</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $totalEmployees }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('employees.index') }}" class="font-medium text-indigo-700 hover:text-indigo-900">View all</a>
            </div>
        </div>
    </div>

    <!-- Present Today Card -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Present Today</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $presentToday }}</div>
                            <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                <span>{{ $totalEmployees > 0 ? number_format(($presentToday / $totalEmployees) * 100, 1) : 0 }}%</span>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('attendances.index') }}" class="font-medium text-indigo-700 hover:text-indigo-900">View attendance</a>
            </div>
        </div>
    </div>

    <!-- Active Vacancies Card -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Vacancies</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $activeVacancies }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('jobs.index') }}" class="font-medium text-indigo-700 hover:text-indigo-900">View all</a>
            </div>
        </div>
    </div>

    <!-- Pending Leave Requests Card -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Leave Requests</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $pendingLeaves }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('leaves.index') }}" class="font-medium text-indigo-700 hover:text-indigo-900">View all</a>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
    <!-- Recent Activities -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Activities</h3>
            <div class="mt-6 flow-root">
                <ul role="list" class="-mb-8">
                    @foreach($recentActivities as $activity)
                    <li>
                        <div class="relative pb-8">
                            @if (!$loop->last)
                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                    <div>
                                        <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                    </div>
                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                        <time datetime="{{ $activity['date'] }}">{{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Department Distribution -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Employee Distribution by Department</h3>
            <div class="mt-6">
                <style>
                    [data-progress] {
                        width: var(--progress-width);
                    }
                </style>
                @foreach($departmentDistribution as $dept)
                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">{{ $dept->department }}</span>
                                <span class="ml-3 text-sm text-gray-500">{{ $dept->count }} employees</span>
                            </div>
                            <div class="mt-2">
                                <div class="relative h-2 rounded-full bg-gray-200">
                                    @php
                                    $width = max(0, min(100, ($dept->count / $totalEmployees) * 100));
                                    @endphp
                                    <div class="absolute h-2 rounded-full bg-indigo-600"
                                        x-data
                                        x-init="$el.style.width = '{{ $width }}%'"></div>
                                </div>
                            </div>
                        </div>
                        <span class="ml-4 text-sm font-medium text-gray-700">{{ number_format(($dept->count / $totalEmployees) * 100, 1) }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection