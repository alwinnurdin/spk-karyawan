<script setup>
import {
    ExclamationCircleIcon,
    MoonIcon,
    SunIcon,
} from '@heroicons/vue/24/solid';
import { Link as InertiaLink, router, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
const page = usePage();

const logout = () => {
    router.post('/logout', {
        _token: page.props.csrf_token,
    });
};

const currentTheme = ref('cupcake');

const toggleTheme = () => {
    const newTheme = currentTheme.value === 'cupcake' ? 'dim' : 'cupcake';
    applyTheme(newTheme);
};

const initializeTheme = () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme && (savedTheme === 'cupcake' || savedTheme === 'dim')) {
        applyTheme(savedTheme);
    } else {
        applyTheme('cupcake');
    }
};

const applyTheme = (theme) => {
    document.documentElement.setAttribute('data-theme', theme);
    currentTheme.value = theme;
    localStorage.setItem('theme', theme);
};

onMounted(() => {
    initializeTheme();
});
</script>

<template>
    <div class="navbar">
        <div class="navbar-start">
            <div class="dropdown">
                <div
                    tabindex="0"
                    role="button"
                    class="btn btn-circle btn-ghost pl-1"
                >
                    <ExclamationCircleIcon class="h-6 w-6" />
                </div>
                <ul
                    tabindex="0"
                    class="menu dropdown-content rounded-box bg-base-100 z-[1] mt-3 w-52 p-2"
                >
                    <li>
                        <button onclick="about_modal.showModal()">About</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="navbar-center gap-4">
            <InertiaLink href="/">Home</InertiaLink>
            <InertiaLink href="/inputdata">Input Data</InertiaLink>
            <InertiaLink href="/matrix">Nilai Karyawan</InertiaLink>
            <InertiaLink href="/profile">Profil</InertiaLink>
        </div>

        <div class="navbar-end">
            <div class="dropdown dropdown-end">
                <!-- <div
                    v-if="user.name"
                    tabindex="0"
                    role="button"
                    class="btn rounded-btn"
                >
                    {{ user.name }}
                </div> -->
                <ul
                    tabindex="0"
                    class="menu dropdown-content rounded-box bg-base-100 z-[1] mt-4 w-52 p-2"
                >
                    <li>
                        <form @submit.prevent="logout">
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            <label class="swap swap-rotate mx-4">
                <!-- this hidden checkbox controls the state -->
                <input
                    type="checkbox"
                    class="theme-controller hidden"
                    :checked="currentTheme === 'cupcake'"
                    @change="toggleTheme"
                />
                <!-- sun icon -->
                <SunIcon class="swap-off size-5" />
                <!-- moon icon -->
                <MoonIcon class="swap-on size-5" />
            </label>
        </div>
    </div>
    <dialog id="about_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">About Encrypt It</h3>
            <p class="py-4">
                Didalam sistem ini digunakan algoritma SAW atau yang bisa
                disingkat dengan Simple Additive Weighting
            </p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</template>
