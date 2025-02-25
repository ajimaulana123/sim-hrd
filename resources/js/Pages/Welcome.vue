<template>
    <Head>
        <title>HRD System - Modern HR Management Made Simple</title>
        <meta name="description" content="Transform your HR processes with our comprehensive Human Resource Development System. Experience seamless employee management, real-time attendance tracking, and efficient leave management.">
        <meta name="keywords" content="HR management, employee management, attendance tracking, leave management, HRD system">
        <meta property="og:title" content="HRD System - Modern HR Management Made Simple">
        <meta property="og:description" content="Transform your HR processes with our comprehensive Human Resource Development System.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://hrd-system.com">
        <meta property="og:image" content="/images/og-image.jpg">
        <link rel="canonical" href="https://hrd-system.com">
    </Head>

    <div class="min-h-screen bg-gray-50">
        <HeroSection />
        <FeaturesSection />
        <StatsSection />
        <FooterSection />
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/Landing/HeroSection.vue';
import FeaturesSection from '@/Components/Landing/FeaturesSection.vue';
import StatsSection from '@/Components/Landing/StatsSection.vue';
import FooterSection from '@/Components/Landing/FooterSection.vue';
</script> 