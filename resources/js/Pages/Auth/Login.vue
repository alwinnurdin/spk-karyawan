<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ExclamationTriangleIcon } from '@heroicons/vue/24/solid';

const page = usePage();

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
    _token: page.props.csrf,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <div v-if="status" class="mb-4 text-sm font-medium">
            {{ status }}
        </div>

        <div class="bg-base-100 flex justify-center">
            <div class="mx-64 mt-20 min-w-96 rounded-xl p-4 outline-2">
                <h1 class="text-center text-3xl font-extrabold">Sign in</h1>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <!-- Login error -->
                    <!-- <div class="mt-4 block">
                        <div role="alert" class="alert">
                            <ExclamationTriangleIcon
                                class="text-warning h-5 w-5"
                            />
                            <span>Gagal Login: Page Expire</span>
                        </div>
                    </div> -->

                    <div class="mt-4 block">
                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.remember"
                            />
                            <span class="ms-2 text-sm">Remember me</span>
                        </label>
                    </div>

                    <div class="mt-16 block">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col items-start gap-3">
                                <Link href="/register" class="text-sm underline"
                                    >Create new account</Link
                                >
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm underline"
                                >
                                    Forgot your password?
                                </Link>
                            </div>
                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Log in
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
