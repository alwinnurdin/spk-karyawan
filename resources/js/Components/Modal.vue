<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive, ref, watch } from 'vue';

const props = defineProps({
    modelValue: Boolean,
    title: String,
    type: String,
    editData: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['update:modelValue', 'submit']);

const form = reactive({
    type: props.type,
    data: {
        name: '',
        email: '',
        role: '',
        dob: '',
        weight: '',
        attribute: '',
        value: '',
    },
});

const validationError = ref(null);

function calculateAge(dob) {
    if (!dob) return 0;
    const birthDate = new Date(dob);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (
        monthDiff < 0 ||
        (monthDiff === 0 && today.getDate() < birthDate.getDate())
    ) {
        age--;
    }
    return age;
}

function validateForm() {
    // Reset validation error
    validationError.value = null;

    // Validate age
    const age = calculateAge(form.data.dob);
    if (isNaN(age) || (age < 18 && form.type === 'alternative')) {
        validationError.value = 'Harus berusia 18 tahun ke atas!';
        return false;
    }

    return true;
}

const handleSubmit = () => {
    if (!validateForm()) {
        return;
    }

    emit('submit', {
        ...form,
        type: form.type,
    });
    emit('update:modelValue', false);
};

// Watch for editData changes
watch(
    () => props.editData,
    (newVal) => {
        if (newVal) {
            form.data = { ...newVal };
        }
    },
    { immediate: true },
);

// Reset form when modal closes
watch(
    () => props.modelValue,
    (newVal) => {
        if (!newVal && !props.editData) {
            form.data = {
                name: '',
                email: '',
                role: '',
                dob: '',
                weight: '',
                attribute: '',
                value: '',
            };
            validationError.value = null;
        }
    },
);
</script>

<template>
    <dialog
        class="modal"
        :open="modelValue"
        @close="$emit('update:modelValue', false)"
    >
        <div class="modal-box relative max-w-64">
            <h3 v-mode="form.type" class="text-lg font-bold">
                {{ form.type }}
            </h3>
            <button
                class="btn btn-circle btn-ghost btn-sm absolute top-2 right-2"
                type="button"
                @click="$emit('update:modelValue', false)"
            >
                ✕
            </button>

            <form @submit.prevent="handleSubmit" class="mt-4 space-y-3">
                <!-- Display validation error with proper styling -->
                <div v-if="validationError" class="alert alert-error text-sm">
                    {{ validationError }}
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>
                    <input
                        v-model="form.data.name"
                        type="text"
                        class="input input-bordered w-full"
                        required
                    />
                </div>
                <template v-if="type === 'alternative'">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input
                            v-model="form.data.email"
                            type="email"
                            class="input input-bordered w-full"
                            required
                        />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tanggal Lahir</span>
                        </label>
                        <input
                            v-model="form.data.dob"
                            type="date"
                            class="input input-bordered w-full"
                            required
                        />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Jabatan</span>
                        </label>
                        <select
                            class="select select-bordered w-full"
                            v-model="form.data.role"
                            required
                        >
                            <option value="" disabled selected>
                                Pilih Jabatan
                            </option>
                            <option value="karyawan">karyawan</option>
                            <option value="admin">admin</option>
                            <option value="manager">manager</option>
                        </select>
                    </div>
                </template>

                <!-- Criteria-specific fields -->
                <template v-if="type === 'criteria'">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Bobot</span>
                        </label>
                        <input
                            v-model="form.data.weight"
                            type="number"
                            step="0.01"
                            class="input input-bordered w-full"
                            required
                        />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Atribut</span>
                        </label>
                        <select
                            class="select select-bordered w-full"
                            v-model="form.data.attribute"
                            required
                        >
                            <option value="" disabled selected>
                                Pilih Kriteria
                            </option>
                            <option value="cost">Cost</option>
                            <option value="benefit">Benefit</option>
                        </select>
                    </div>
                </template>

                <template v-else-if="type === 'subcriteria'">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nilai</span>
                        </label>
                        <input
                            v-model="form.data.value"
                            type="number"
                            step="0.01"
                            class="input input-bordered w-full"
                            required
                        />
                    </div>
                </template>

                <div class="modal-action">
                    <PrimaryButton type="submit">Proses</PrimaryButton>
                </div>
            </form>
        </div>
    </dialog>
</template>
