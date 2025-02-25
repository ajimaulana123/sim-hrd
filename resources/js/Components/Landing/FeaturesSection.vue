<template>
    <section id="about" class="py-24 bg-white scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-amber-600 font-semibold tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Everything you need to manage your workforce
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Our comprehensive suite of HR tools helps you streamline operations and boost productivity.
                </p>
            </div>

            <div class="mt-20">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div v-for="feature in features" :key="feature.name" class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-gradient-to-r from-amber-500 to-amber-600 text-white">
                                <component :is="feature.icon" class="h-6 w-6" aria-hidden="true" />
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{ feature.name }}</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">{{ feature.description }}</dd>
                        <div class="mt-3 ml-16">
                            <ul class="space-y-2">
                                <li v-for="(point, index) in feature.points" :key="index" class="flex items-start">
                                    <CheckIcon class="h-5 w-5 text-amber-500 mt-0.5" />
                                    <span class="ml-2 text-gray-600">{{ point }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>

<script setup>
import { 
    UsersIcon,
    ClockIcon,
    CalendarDaysIcon,
    ChartBarIcon,
    CheckIcon
} from '@heroicons/vue/24/outline';

const features = [
    {
        name: 'Employee Management',
        description: 'Comprehensive employee profiles and organizational structure management.',
        icon: UsersIcon,
        points: [
            'Detailed employee profiles',
            'Department organization',
            'Position management',
            'Document storage'
        ]
    },
    {
        name: 'Attendance Tracking',
        description: 'Real-time attendance monitoring with advanced reporting.',
        icon: ClockIcon,
        points: [
            'Clock in/out system',
            'Attendance reports',
            'Work hour calculations',
            'Overtime tracking'
        ]
    },
    {
        name: 'Leave Management',
        description: 'Streamlined leave request and approval workflow.',
        icon: CalendarDaysIcon,
        points: [
            'Multiple leave types',
            'Automated approvals',
            'Leave balance tracking',
            'Calendar integration'
        ]
    },
    {
        name: 'Performance Analytics',
        description: 'Data-driven insights for better decision making.',
        icon: ChartBarIcon,
        points: [
            'Performance metrics',
            'Department analytics',
            'Attendance statistics',
            'Custom reports'
        ]
    }
];
</script> 