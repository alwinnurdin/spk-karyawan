<script setup>
import { ref, onMounted } from 'vue';
import AccentButton from '@/Components/AccentButton.vue';
import { ArrowLeftIcon } from '@heroicons/vue/24/solid';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import TopBar from '@/Components/TopBar.vue';
import { Link as InertiaLink } from '@inertiajs/vue3';

const criteriaData = ref([]);
const subcriteriaData = ref([]);
const alternativesData = ref([]);
const scoresData = ref([]);
const selectedValues = ref({});
const showPhone = ref(false);
const recommendedPhone = ref('');
const recommendationSection = ref(null);

onMounted(async () => {
    try {
        await fetchItems();
    } catch (error) {
        console.error('Error fetching items:', error);
    }
});

const fetchItems = async () => {
    try {
        const response = await axios.get('/getdata');
        const data = response.data.data;

        // Extract relevant data
        criteriaData.value = data.criteria;
        subcriteriaData.value = data.subcriteria;
        alternativesData.value = data.alternative;
        scoresData.value = data.score;
    } catch (error) {
        console.error('Error fetching items:', error);
    }
};

const getSubcriteria = (criterionId) => {
    return subcriteriaData.value.filter(
        (sub) => sub.criteria_id === criterionId,
    );
};

const saveValue = async () => {
    showPhone.value = true;

    // Filter logic based on selected criteria
    const activeCriteria = Object.keys(selectedValues.value).filter(
        (criterionId) => selectedValues.value[criterionId],
    );

    let filteredAlternatives = [];

    if (activeCriteria.length === 1) {
        // If only one criterion is selected
        const criterionId = activeCriteria[0];
        const selectedValue = selectedValues.value[criterionId];
        filteredAlternatives = alternativesData.value.filter((alternative) => {
            const score = scoresData.value.find(
                (s) =>
                    s.alternative_id === alternative.id &&
                    s.criteria_id === parseInt(criterionId, 10),
            );
            return score && score.value === selectedValue;
        });
    } else if (activeCriteria.length > 1) {
        // If multiple criteria are selected
        filteredAlternatives = alternativesData.value.filter((alternative) => {
            return activeCriteria.every((criterionId) => {
                const selectedValue = selectedValues.value[criterionId];
                const score = scoresData.value.find(
                    (s) =>
                        s.alternative_id === alternative.id &&
                        s.criteria_id === parseInt(criterionId, 10),
                );
                return score && score.value === selectedValue;
            });
        });
    }

    // Set the recommended phone
    recommendedPhone.value =
        filteredAlternatives.length > 0
            ? filteredAlternatives[0].name
            : 'Tidak ditemukan';

    // Clear selected values
    selectedValues.value = {};

    // Scroll to the recommendation section
    if (recommendationSection.value) {
        recommendationSection.value.scrollIntoView({ behavior: 'smooth' });
    }
};
</script>

<template>
    <Head :title="Rekomendasi" />
    <TopBar />

    <div class="bg-base-300 min-h-screen px-4 py-10">
        <div class="container mx-auto max-w-2xl">
            <!-- Phone Display Section -->
            <div v-if="showPhone" class="mb-8">
                <div class="mx-auto w-64">
                    <svg
                        viewBox="0 0 300 600"
                        class="w-full"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <!-- Phone Frame -->
                        <rect
                            x="10"
                            y="10"
                            width="280"
                            height="580"
                            rx="40"
                            fill="#333"
                        />
                        <!-- Screen -->
                        <rect
                            x="20"
                            y="20"
                            width="260"
                            height="560"
                            rx="35"
                            fill="#1a1a1a"
                        />
                        <!-- Notch -->
                        <rect
                            x="100"
                            y="25"
                            width="100"
                            height="25"
                            rx="12"
                            fill="#333"
                        />
                        <!-- Text Content -->
                        <text
                            x="150"
                            y="250"
                            text-anchor="middle"
                            fill="white"
                            class="text-lg"
                        >
                            Rekomendasi Smartphone
                        </text>
                        <text
                            x="150"
                            y="280"
                            text-anchor="middle"
                            fill="white"
                            class="text-lg"
                        >
                            anda adalah
                        </text>
                        <text
                            x="150"
                            y="320"
                            text-anchor="middle"
                            fill="white"
                            font-weight="bold"
                            class="text-xl"
                        >
                            {{ recommendedPhone }}
                        </text>
                    </svg>
                </div>
            </div>

            <!-- Criteria Selection Section -->
            <div class="bg-base-300 rounded-lg p-6 shadow-lg">
                <h3 class="mb-6 text-center text-xl font-bold">
                    Pilih Kriteria Smartphone
                </h3>

                <div class="space-y-4">
                    <div
                        v-for="criterion in criteriaData"
                        :key="criterion.id"
                        class="form-control"
                    >
                        <label class="label">
                            <span class="label-text">{{ criterion.name }}</span>
                        </label>
                        <select
                            v-model="selectedValues[criterion.id]"
                            class="select select-bordered w-full"
                        >
                            <option value="" disabled>
                                Select {{ criterion.name }}
                            </option>
                            <option
                                v-for="sub in getSubcriteria(criterion.id)"
                                :key="sub.id"
                                :value="sub.value"
                            >
                                {{ sub.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-center gap-4">
                    <InertiaLink href="/home">
                        <AccentButton class="flex items-center gap-2">
                            <ArrowLeftIcon class="h-5 w-5" />
                            Kembali
                        </AccentButton>
                    </InertiaLink>
                    <button class="btn btn-primary" @click="saveValue">
                        Rekomendasikan
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
