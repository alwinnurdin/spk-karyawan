<script setup>
import {
    DocumentChartBarIcon,
    HomeIcon,
    NumberedListIcon,
    UserCircleIcon,
} from '@heroicons/vue/24/solid';
import { Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

// const page = usePage();
const isOpen = ref(localStorage.getItem('sidebarOpen') === 'true' || false);

watch(isOpen, (newValue) => {
    localStorage.setItem('sidebarOpen', newValue);
});
const isActive = (path) => {
    return window.location.pathname === path;
};
</script>

<template>
    <ul
        class="menu bg-base-200 md:menu-horizontal rounded-box flex w-full justify-center gap-4"
    >
        <li>
            <Link href="/" :class="{ active: isActive('/') }">
                <HomeIcon class="size-[1.2em]" />
                <span
                    class="dock-label font-bold"
                    :class="{ 'border-info border-b-4': $page.url === '/' }"
                    >Home</span
                >
            </Link>
        </li>
        <div class="divider-vertical"></div>
        <li>
            <Link href="/inputdata">
                <DocumentChartBarIcon class="size-[1.2em]" />
                <span
                    class="dock-label font-bold"
                    :class="{
                        'border-info border-b-4': $page.url === '/inputdata',
                    }"
                    >Input Data</span
                >
            </Link>
        </li>
        <li>
            <Link
                href="/matrix"
                :class="{ 'dock-active': isActive('/matrix') }"
            >
                <NumberedListIcon class="size-[1.2em]" />
                <span
                    class="dock-label font-bold"
                    :class="{
                        'border-info border-b-4': $page.url === '/matrix',
                    }"
                    >Nilai Karyawan</span
                >
            </Link>
        </li>
        <li>
            <Link
                href="/profile"
                :class="{ 'dock-active': isActive('/profile') }"
            >
                <UserCircleIcon class="size-[1.2em]" />
                <span
                    class="dock-label font-bold"
                    :class="{
                        'border-info border-b-4': $page.url === '/profile',
                    }"
                    >Profil</span
                >
            </Link>
        </li>
    </ul>
    <div class="flex flex-row justify-between pt-2">
        <main class="max-h-[86vh] w-full flex-1 overflow-auto p-8">
            <slot />
        </main>
    </div>
</template>
