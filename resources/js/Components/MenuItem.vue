<script setup>
import {
    DocumentChartBarIcon,
    HomeIcon,
    NumberedListIcon,
    UserCircleIcon,
} from '@heroicons/vue/24/solid';
import { Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const isOpen = ref(localStorage.getItem('sidebarOpen') === 'true' || false);

watch(isOpen, (newValue) => {
    localStorage.setItem('sidebarOpen', newValue);
});

const isActive = (path) => {
    return window.location.pathname === path;
};
</script>

<template>
    <main class="mb-15 p-4">
        <slot />
    </main>
    <div class="dock dock-top bg-base-300">
        <Link
            href="/preferensi"
            :class="{ 'dock-active': isActive('/preferensi') }"
        >
            <HomeIcon class="size-[1.2em]" />
            <span class="dock-label font-bold">Home</span>
        </Link>
        <button class="dock-active">hello</button>
        <button
            class="dock-active"
            :class="{ 'dock-active active': isActive('/inputdata') }"
        >
            <Link href="/input-data">
                <DocumentChartBarIcon class="size-[1.2em]" />
                <span class="dock-label font-bold">Input Data</span>
            </Link>
        </button>

        <Link href="/" :class="{ 'dock-active': isActive('/') }">
            <NumberedListIcon class="size-[1.2em]" />
            <span class="dock-label font-bold">Nilai Karyawan</span>
        </Link>

        <Link href="/profile" :class="{ 'dock-active': isActive('/profile') }">
            <UserCircleIcon class="size-[1.2em]" />
            <span class="dock-label font-bold">Profil</span>
        </Link>
    </div>
</template>
