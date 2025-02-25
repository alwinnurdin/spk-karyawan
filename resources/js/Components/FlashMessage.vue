<script setup>
import { ExclamationCircleIcon } from '@heroicons/vue/24/solid';
defineProps({
    show: Boolean,
    message: String,
});
</script>

<template>
    <div v-if="show" class="toast toast-top toast-end z-50">
        <div class="alert font-bold">
            <ExclamationCircleIcon class="size-5" />
            <span> {{ message }}</span>
        </div>
    </div>
</template>
