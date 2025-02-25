<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link as InertiaLink } from '@inertiajs/vue3';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Homepage" />
        <!-- <TopBar /> -->
        <div class="hero bg-base-300 flex h-screen justify-center">
            <div class="hero-content -mt-30 text-center">
                <div class="max-w-lg">
                    <h1 class="text-4xl font-bold capitalize">
                        Sistem Pemilihan Karyawan Terbaik menggunakan metode
                        <i> simple additive weighting (SAW) dan weighted product (WP) </i>  pada ulik coffee & eatery
                    </h1>
                    <div class="mt-10 flex justify-center gap-2">
                        <!-- <InertiaLink href="/login"
                            ><a class="btn btn-info"> Login </a></InertiaLink
                        > -->

                        <InertiaLink href="/preferensi">
                            <button class="btn btn-primary">Ranking</button>
                        </InertiaLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
