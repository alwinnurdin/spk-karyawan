<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link as InertiaLink, router, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, nextTick, ref, watch } from 'vue';

const page = usePage();
const tableData = computed(
    () => page.props.data || { alternative: [], criteria: [], subcriteria: [] },
);
const selectedAlternative = ref(null);
const selectedCriterion = ref(null);
const selectedValue = ref('');
const values = ref({});
const showToast = ref(false);
const toastMessage = ref('');

const getSubcriteria = (criterionId) => {
    return tableData.value.subcriteria.filter(
        (sub) => sub.criteria_id === criterionId,
    );
};

const getValue = (alternativeId, criteriaId) => {
    const score = tableData.value.score.find(
        (s) =>
            s.alternative_id === alternativeId && s.criteria_id === criteriaId,
    );
    return score ? score.value : 'ss';
};

const openModal = (alternative, criterion) => {
    selectedAlternative.value = alternative;
    selectedCriterion.value = criterion;
    selectedValue.value = getValue(alternative.id, criterion.id) || '';
    document.getElementById('criterion_modal').showModal();
};

const closeModal = () => {
    document.getElementById('criterion_modal').close();
    resetModal();
};

const resetModal = () => {
    selectedAlternative.value = null;
    selectedCriterion.value = null;
    selectedValue.value = '';
};

const saveValue = async () => {
    if (!selectedAlternative.value || !selectedCriterion.value) return;

    if (!values.value[selectedAlternative.value.id]) {
        values.value[selectedAlternative.value.id] = {};
    }

    values.value[selectedAlternative.value.id][selectedCriterion.value.id] =
        selectedValue.value;

    try {
        await nextTick();
        await axios.post('/addscore', {
            alternative_id: selectedAlternative.value.id,
            criteria_id: selectedCriterion.value.id,
            value: selectedValue.value,
        });

        closeModal();
        router.reload({ only: ['data'] });
    } catch (error) {
        console.error('Error saving value:', error);
    }
};

watch(
    () => page.props.flash || {},
    (flash) => {
        if (flash.message) {
            toastMessage.value = flash.message;
            showToast.value = true;
            setTimeout(() => {
                showToast.value = false;
            }, 3000);
        }
    },
    { immediate: true, deep: true },
);
</script>

<template>
    <AuthenticatedLayout>
        <InertiaLink href="/preferensi" class="btn btn-primary mb-10">
            Hasil Penilaian
        </InertiaLink>
        <Head title="Preferensi" />
        <FlashMessage :show="showToast" :message="toastMessage" />
        <div>
            <table class="table-pin-cols table-sm table w-full">
                <thead class="bg-base-300 text-center font-bold">
                    <tr>
                        <th class="text-center" style="width: 5%">
                            Alternatif
                        </th>
                        <th class="text-center" style="width: 15%">Nama</th>
                        <th
                            v-for="criterion in tableData['criteria']"
                            :key="criterion.id"
                            class="text-center"
                        >
                            {{ criterion.name }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, index) in tableData['alternative']"
                        :key="item.id"
                        class="hover bg-base-200"
                    >
                        <td class="text-center">A{{ index + 1 }}</td>
                        <td class="text-center">{{ item.name }}</td>
                        <td
                            v-for="criterion in tableData['criteria']"
                            :key="criterion.id"
                            class="cursor-pointer text-center"
                            @click="openModal(item, criterion)"
                        >
                            <div
                                :class="{
                                    'text-red-500': !getValue(
                                        item.id,
                                        criterion.id,
                                    ),
                                }"
                            >
                                {{
                                    getSubcriteria(criterion.id).find(
                                        (sub) =>
                                            sub.value ===
                                            getValue(item.id, criterion.id),
                                    )?.name || 'pilih'
                                }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="divider my-20"></div>
            <table class="table-pin-cols table-sm mt-20 table w-full">
                <thead class="bg-base-300 text-center font-bold">
                    <tr>
                        <th class="text-center" style="width: 20%">
                            Alternatif
                        </th>
                        <th
                            v-for="(criterion, index) in tableData['criteria']"
                            :key="criterion.id"
                            class="text-center"
                        >
                            C{{ index + 1 }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, index) in tableData['alternative']"
                        :key="item.id"
                        class="hover bg-base-200"
                    >
                        <td class="text-center">A{{ index + 1 }}</td>
                        <td
                            v-for="criterion in tableData['criteria']"
                            :key="criterion.id"
                            class="cursor-pointer text-center"
                            @click="openModal(item, criterion)"
                        >
                            <div
                                :class="{
                                    'text-red-500': !getValue(
                                        item.id,
                                        criterion.id,
                                    ),
                                }"
                            >
                                {{
                                    getSubcriteria(criterion.id).find(
                                        (sub) =>
                                            sub.value ===
                                            getValue(item.id, criterion.id),
                                    )?.value || '-'
                                }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal -->
            <dialog id="criterion_modal" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">
                        Set {{ selectedCriterion?.name }} for
                        {{ selectedAlternative?.name }}
                    </h3>
                    <div class="py-4">
                        <select
                            v-model="selectedValue"
                            class="select select-bordered w-full"
                        >
                            <option value="" disabled>Select a value</option>
                            <option
                                v-for="sub in getSubcriteria(
                                    selectedCriterion?.id,
                                )"
                                :key="sub.id"
                                :value="sub.value"
                            >
                                {{ sub.name }}
                            </option>
                        </select>
                    </div>
                    <div class="modal-action">
                        <button class="btn" @click="closeModal">Cancel</button>
                        <button class="btn btn-primary" @click="saveValue">
                            Save
                        </button>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button>close</button>
                </form>
            </dialog>
        </div>
    </AuthenticatedLayout>
</template>
