<template>
    <Head>
        <title>404 - Page Not Found | HRD System</title>
        <meta name="description" content="The page you're looking for doesn't exist.">
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-amber-100 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full space-y-8 text-center">
            <!-- 404 Illustration -->
            <div class="relative">
                <img src="https://cdn-icons-png.flaticon.com/512/6195/6195678.png" 
                     class="h-48 w-auto mx-auto opacity-75" 
                     alt="404 Illustration">
                <div class="absolute inset-0 bg-gradient-to-t from-amber-50 to-transparent"></div>
            </div>

            <!-- Content -->
            <div>
                <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                    Page not found
                </h1>
                <p class="mt-4 text-base text-gray-500">
                    Sorry, we couldn't find the page you're looking for. The page might have been removed, renamed, or doesn't exist.
                </p>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-center space-x-4">
                <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 transition duration-150 ease-in-out transform hover:scale-105">
                    <img src="https://cdn-icons-png.flaticon.com/512/1946/1946488.png" class="h-5 w-5 mr-2 filter brightness-0 invert" alt="Home">
                    Go back home
                </a>
                <button @click="goBack" class="inline-flex items-center px-4 py-2 border border-amber-300 text-base font-medium rounded-md text-amber-700 bg-amber-50 hover:bg-amber-100 transition duration-150 ease-in-out transform hover:scale-105">
                    <img src="https://cdn-icons-png.flaticon.com/512/507/507257.png" class="h-5 w-5 mr-2 opacity-75" alt="Back">
                    Go back
                </button>
            </div>

            <!-- Help Text -->
            <p class="mt-6 text-sm text-gray-500">
                Need help? <a href="#" class="font-medium text-amber-600 hover:text-amber-500">Contact our support team</a>
            </p>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';

const goBack = () => {
    window.history.back();
};
</script> 