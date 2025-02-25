// formStore.js
import { router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

export const useFormStore = () => {
    const isModalOpen = ref(false);
    const modalType = ref('');
    const editData = ref(null);
    const form = reactive({
        type: 'alternative',
        data: {
            name: '',
            weight: '',
        },
    });
    const alternativeForm = reactive({
        type: 'alternative',
        data: {
            name: '',
        },
    });

    const criteriaForm = reactive({
        type: 'criteria',
        data: {
            name: '',
            weight: '',
            attribute: '',
        },
    });

    const resetForm = (type) => {
        if (type === 'alternative') {
            Object.assign(alternativeForm.data, {
                name: '',
            });
        } else if (type === 'criteria') {
            Object.assign(criteriaForm.data, {
                name: '',
                weight: '',
                attribute: '',
            });
        }

        // Reset main form
        Object.assign(form.data, {
            name: '',
            weight: '',
        });
    };
    const openModal = (item, type) => {
        modalType.value = type;
        isModalOpen.value = true;
        editData.value = item.data;
        resetForm(type);
    };
    const submitForm = async (formType) => {
        const form =
            formType === 'alternative' ? alternativeForm : criteriaForm;
        try {
            const response = router.post('/add', form);

            if (response.data.success) {
                closeModal(`${formType}_modal`);
                resetForm;
                return true;
            }
        } catch (error) {
            console.log(error);
        }
    };

    const handleUpdate = (type, id) => {
        if (!confirm(`Yakin ingin menghapus ${name}?`)) return;
        router.put(`/${type}`, { id });
    };

    const handleEdit = (item, type) => {
        openModal(type, item.data);
    };

    const handleDelete = (type, id, name) => {
        if (!confirm(`Yakin ingin menghapus ${name}?`)) return;

        loading.value = true;

        router.delete(`/${type}/${id}`, {
            preserveScroll: true,
            onFinish: () => {
                loading.value = false;
            },
        });
    };

    return {
        alternativeForm,
        criteriaForm,
        isModalOpen,
        submitForm,
        form,
        editData,
        handleUpdate,
        handleDelete,
        openModal,
        resetForm,
        modalType,
    };
};

export default useFormStore;
