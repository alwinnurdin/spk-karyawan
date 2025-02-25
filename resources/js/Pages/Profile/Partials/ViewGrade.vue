<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
// Reactive variables
const tableData = ref(null);
const alternativeData = ref({});
const criteriaData = ref([]);
const subcriteriaData = ref([]);
const scoreData = ref([]);

// Function to fetch data
const fetchItems = async () => {
    try {
        const dataResponse = await axios.get('/getdata');
        tableData.value = dataResponse.data.data;
        alternativeData.value = tableData.value.alternative;
        criteriaData.value = tableData.value.criteria;
        subcriteriaData.value = tableData.value.subcriteria;
        scoreData.value = tableData.value.score;
    } catch (error) {
        console.error('Error fetching items:', error);
    }
};

// Lifecycle hook
onMounted(async () => {
    await fetchItems();
});
</script>

<template>
    <section class="space-y-6">
        <!-- <header>
            <h2 class="text-lg font-medium">Nilai Karyawan</h2>
            <p class="mt-1 text-sm">Disini rangkuman nilai anda:</p>
            <div class="container flex items-center justify-end pt-4"></div>
        </header> -->

        <!-- Alternative Data -->
        <!-- <ul>
            ID:
            <b>{{ $page.props.auth.user.id }}</b>
        </ul> -->
        <ul>
            Nama Lengkap:
            <b>{{ $page.props.auth.user.name }}</b>
        </ul>

        <ul>
            E-mail:
            <b>{{ $page.props.auth.user.email }}</b>
        </ul>
        <ul>
            Tanggal Lahir:
            <b>{{
                new Date($page.props.auth.user.dob).toLocaleDateString(
                    'id-ID',
                    {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                    },
                )
            }}</b>
        </ul>
        <!-- <ul>
            Jabatan:
            <b>{{ $page.props.auth.user.role }}</b>
        </ul> -->

        <!-- <h3 class="divider mb-8 text-xl font-bold">Nilai</h3>

        <!-- Score Table -->
        <div class="flex-center mb-20">
            <div class="flex-center container items-center">
                <!-- <table class="table items-center">
                    <thead class="bg-base-300 text-center font-bold">
                        <th
                            v-for="criterion in $page.props.data.criteria"
                            :key="criterion.id"
                            class="text-center"
                        >
                            {{ criterion.name }}
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td v-for="item in scoreData" :key="item.id">
                                {{ item.value }}
                            </td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </div>
    </section>
</template> -->
