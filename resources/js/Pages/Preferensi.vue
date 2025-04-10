<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';
import { computed, onMounted, ref } from 'vue';

// Register all Chart.js components
Chart.register(...registerables);

// Reactive data
const tableData = ref(null);
const selectedMethod = ref('saw'); // Default method

// Refs for Charts
const rankingChartRef = ref(null);
let rankingChart = null;

// Fetch Data Function (API call)
const fetchTableData = async () => {
    try {
        const endpoint = `/${selectedMethod.value}/calculate`; // Use selected method
        const response = await axios.get(endpoint);

        if (response.data.success) {
            tableData.value = response.data.data;
            createRankingChart();
        } else {
            console.error('Failed to fetch data');
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

// Initialize Ranking Bar Chart (Limit to top 3 rankings)
const createRankingChart = () => {
    if (!tableData.value?.ranking) return;

    if (rankingChart) rankingChart.destroy();

    const top3Ranking = tableData.value.ranking.slice(0, 3);
    const labels = top3Ranking.map((item) => item.name);
    const data = top3Ranking.map((item) => item.score);

    rankingChart = new Chart(rankingChartRef.value, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Final Score',
                    data,
                    backgroundColor: 'rgba(255, 165, 0, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};

// Computed property to get the number of criteria
const getCriteria = computed(() => {
    if (!tableData.value?.matrix) return 0;
    const firstValue = Object.values(tableData.value.matrix)[0];
    return firstValue ? Object.keys(firstValue).length : 0;
});
// const getAlternative = computed(() => {
//     if (!tableData.value?.matrix) return 0;
//     const firstValue = Object.values(tableData.value.matrix);
//     return firstValue ? Object.keys(firstValue).length : 0;
// });
// Watch for method changes
const handleMethodChange = () => {
    fetchTableData(); // Fetch data when method changes
};

// Fetch data on mount
onMounted(() => {
    fetchTableData();
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="space-y-8">
            <!-- Select Method -->
            <div class="mx-40 my-4">
                <label for="method" class="mr-4 text-lg font-bold"
                    >Pilih Metode:</label
                >
                <select
                    id="method"
                    v-model="selectedMethod"
                    @change="handleMethodChange"
                    class="select select-bordered w-full max-w-xs"
                >
                    <option value="saw">SAW</option>
                    <option value="wp">WP</option>
                </select>
            </div>

            <!-- Ranking Bar Chart -->
            <div class="card mx-40">
                <h2 class="mb-10 text-center text-xl font-bold">
                    Top 3 Karyawan
                </h2>
                <div class="relative h-80">
                    <canvas ref="rankingChartRef"></canvas>
                </div>
            </div>

            <!-- Original Tables -->
            <div
                v-if="tableData && tableData['matrix']"
                class="flex overflow-auto"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th
                                v-for="(value, index) in Array.from(
                                    { length: getCriteria },
                                    (_, i) => i,
                                )"
                                :key="index"
                                style="10%"
                            >
                                C{{ index + 1 }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr
                            v-for="(item, index, iter) in tableData['matrix']"
                            :key="index"
                        >
                            <td>A{{ iter + 1 }}</td>
                            <td v-for="(child, key) in item" :key="key">
                                {{ child }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Weighted, Normalization, and Ranking Tables -->
            <h2
                v-if="selectedMethod !== 'wp'"
                class="divider text-xl font-bold"
            >
                Bobot dan Kriteria
            </h2>
            <div
                class="flex overflow-auto"
                v-if="tableData && tableData['normalization']"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th
                                v-for="(value, index) in Array.from(
                                    { length: getCriteria },
                                    (_, i) => i,
                                )"
                                :key="index"
                                style="10%"
                            >
                                C{{ index + 1 }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr
                            v-for="(item, index, iter) in tableData[
                                'normalization'
                            ]"
                            :key="index"
                        >
                            <td>A{{ iter + 1 }}</td>
                            <td v-for="(child, key) in item" :key="key">
                                {{ parseFloat(child).toFixed(3) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2
                v-if="selectedMethod !== 'wp'"
                class="divider text-xl font-bold"
            >
                Normalisasi
            </h2>
            <div
                class="flex overflow-auto"
                v-if="tableData && tableData['weighted']"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th
                                v-for="(value, key) in tableData['matrix'][1]"
                                :key="key"
                                class="text-center"
                            >
                                C{{ key }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr
                            v-for="(item, index, iter) in tableData['weighted']"
                            :key="index"
                        >
                            <td>A{{ iter + 1 }}</td>
                            <td v-for="(child, key) in item" :key="key">
                                {{ parseFloat(child).toFixed(3) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="divider text-xl font-bold">Ranking</h2>
            <div
                class="flex overflow-auto"
                v-if="tableData && tableData['ranking']"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th style="width: 25%">Nama</th>
                            <th style="width: 25%">Nilai</th>
                            <th style="width: 25%">Ranking</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- <tr v-for="(item, index) in tableData['ranking']" :key="item.id"> -->
                        <!-- <td>A{{ index + 1 }}</td> -->
                        <tr v-for="item in tableData['ranking']" :key="item.id">
                            <td>{{ item.alternative_name }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ parseFloat(item.score).toFixed(3) }}</td>
                            <td class="font-bold">{{ item.rank }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
