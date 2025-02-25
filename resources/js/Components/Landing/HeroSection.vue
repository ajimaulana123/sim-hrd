<template>
    <section class="relative overflow-hidden bg-gradient-to-br from-amber-50 via-white to-amber-100">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-4 -right-4 w-72 h-72 bg-amber-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-8 -left-4 w-72 h-72 bg-amber-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-amber-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:w-full lg:pb-28 xl:pb-32">
                <!-- Navigation -->
                <div class="pt-6">
                    <nav class="relative flex items-center justify-between sm:h-10 px-4 sm:px-6 lg:px-8" aria-label="Global">
                        <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                            <div class="flex items-center justify-between w-full md:w-auto">
                                <a href="/" class="flex items-center space-x-3">
                                    <img class="h-8 w-auto sm:h-10" src="https://cdn-icons-png.flaticon.com/512/2942/2942789.png" alt="HRD System Logo">
                                    <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-amber-600 to-amber-500 bg-clip-text text-transparent">HRD System</span>
                                </a>
                                <div class="-mr-2 flex items-center md:hidden">
                                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500" aria-expanded="false">
                                        <span class="sr-only">Open main menu</span>
                                        <img v-if="!mobileMenuOpen" src="https://cdn-icons-png.flaticon.com/512/8367/8367536.png" class="h-6 w-6" alt="Menu">
                                        <img v-else src="https://cdn-icons-png.flaticon.com/512/2976/2976286.png" class="h-6 w-6" alt="Close">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:flex md:items-center md:justify-end md:space-x-8">
                            <a @click.prevent="scrollToSection('features')" href="#features" class="font-medium text-gray-500 hover:text-amber-600 transition-colors duration-200 cursor-pointer">Features</a>
                            <a @click.prevent="scrollToSection('about')" href="#about" class="font-medium text-gray-500 hover:text-amber-600 transition-colors duration-200 cursor-pointer">About</a>
                            <a @click.prevent="scrollToSection('testimonials')" href="#testimonials" class="font-medium text-gray-500 hover:text-amber-600 transition-colors duration-200 cursor-pointer">Testimonials</a>
                            <a href="/admin" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 transition-all duration-200 hover:shadow-lg">
                                Sign In
                                <img src="https://cdn-icons-png.flaticon.com/512/747/747305.png" class="ml-2 -mr-1 h-4 w-4 filter brightness-0 invert">
                            </a>
                        </div>
                    </nav>
                    <!-- Mobile menu -->
                    <div v-show="mobileMenuOpen" class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden z-50">
                        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
                            <div class="px-5 pt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img class="h-8 w-auto" src="https://cdn-icons-png.flaticon.com/512/2942/2942789.png" alt="HRD System Logo">
                                    <span class="text-xl font-bold bg-gradient-to-r from-amber-600 to-amber-500 bg-clip-text text-transparent">HRD System</span>
                                </div>
                                <div class="-mr-2">
                                    <button @click="mobileMenuOpen = false" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500">
                                        <span class="sr-only">Close main menu</span>
                                        <img src="https://cdn-icons-png.flaticon.com/512/2976/2976286.png" class="h-6 w-6" alt="Close">
                                    </button>
                                </div>
                            </div>
                            <div class="px-2 pt-2 pb-3 space-y-1">
                                <a @click.prevent="scrollToSection('features')" href="#features" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Features</a>
                                <a @click.prevent="scrollToSection('about')" href="#about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">About</a>
                                <a @click.prevent="scrollToSection('testimonials')" href="#testimonials" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Testimonials</a>
                            </div>
                            <a href="/admin" class="block w-full px-5 py-3 text-center font-medium text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700">
                                Sign In
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Hero Content -->
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Modern HR Management</span>
                            <span class="block text-amber-600 xl:inline"> Made Simple</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Transform your HR processes with our comprehensive Human Resource Development System. 
                            Experience seamless employee management, real-time attendance tracking, and efficient leave management - all in one powerful platform.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="/admin" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 md:py-4 md:text-lg md:px-10 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg">
                                    <span>Get Started</span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/9131/9131510.png" class="ml-2 -mr-1 h-5 w-5 filter brightness-0 invert">
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#features" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-amber-700 bg-amber-100 hover:bg-amber-200 md:py-4 md:text-lg md:px-10 transition duration-300 ease-in-out transform hover:scale-105">
                                    <span>Learn More</span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/2985/2985150.png" class="ml-2 -mr-1 h-5 w-5 opacity-75">
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <div class="relative h-56 w-full sm:h-72 md:h-96 lg:h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-100 to-amber-50 opacity-30"></div>
                <img 
                    class="absolute inset-0 w-full h-full object-cover" 
                    src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" 
                    alt="HR Management Dashboard"
                >
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/70 to-transparent"></div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { ArrowRightIcon, ChevronDownIcon } from '@heroicons/vue/24/outline';

const mobileMenuOpen = ref(false);

const scrollToSection = (sectionId) => {
    mobileMenuOpen.value = false;
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
};

defineProps({
    title: {
        type: String,
        default: 'Modern HR Management Made Simple'
    },
    description: {
        type: String,
        default: 'Transform your HR processes with our comprehensive Human Resource Development System.'
    }
});
</script>

<style scoped>
.bg-grid-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23000000' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style> 