<template>
    <AdminLayout title="Categories">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <button @click="openCreateModal"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Category
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                                        Slug
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                                        Parent Category
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="category in categories" :key="category.id">
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        {{ category.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        {{ category.slug }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        {{ category.parent?.name || 'None' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        {{ category.description || 'No description' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        <button @click="editCategory(category)"
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded mr-2">
                                            Edit
                                        </button>
                                        <button @click="deleteCategory(category)"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="modalOpen" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ isEditing ? 'Edit Category' : 'Create Category' }}
                </h2>

                <form @submit.prevent="submitForm" class="mt-6">
                    <div class="mt-6">
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                        />
                        <InputError :message="errors.name" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <InputLabel for="slug" value="Slug" />
                        <TextInput
                            id="slug"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.slug"
                            required
                        />
                        <InputError :message="errors.slug" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <InputLabel for="parent_id" value="Parent Category" />
                        <select
                            id="parent_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.parent_id"
                        >
                            <option :value="null">None</option>
                            <option v-for="parent in parentCategories" :key="parent.id" :value="parent.id">
                                {{ parent.name }}
                            </option>
                        </select>
                        <InputError :message="errors.parent_id" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <InputLabel for="description" value="Description" />
                        <textarea
                            id="description"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.description"
                            rows="3"
                        ></textarea>
                        <InputError :message="errors.description" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal" class="mr-3">
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton :disabled="processing">
                            {{ isEditing ? 'Update' : 'Create' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    categories: {
        type: Array,
        required: true
    },
    parentCategories: {
        type: Array,
        required: true
    }
});

const modalOpen = ref(false);
const isEditing = ref(false);
const processing = ref(false);
const errors = ref({});

const form = useForm({
    id: null,
    name: '',
    slug: '',
    description: '',
    parent_id: null
});

const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    modalOpen.value = true;
};

const editCategory = (category) => {
    isEditing.value = true;
    form.id = category.id;
    form.name = category.name;
    form.slug = category.slug;
    form.description = category.description;
    form.parent_id = category.parent_id;
    modalOpen.value = true;
};

const closeModal = () => {
    modalOpen.value = false;
    form.reset();
    errors.value = {};
};

const submitForm = () => {
    processing.value = true;
    if (isEditing.value) {
        form.put(route('admin.categories.update', form.id), {
            onSuccess: () => {
                closeModal();
                processing.value = false;
            },
            onError: (err) => {
                errors.value = err;
                processing.value = false;
            }
        });
    } else {
        form.post(route('admin.categories.store'), {
            onSuccess: () => {
                closeModal();
                processing.value = false;
            },
            onError: (err) => {
                errors.value = err;
                processing.value = false;
            }
        });
    }
};

const deleteCategory = (category) => {
    if (confirm('Are you sure you want to delete this category?')) {
        form.delete(route('admin.categories.destroy', category.id));
    }
};

watch(() => form.name, (newValue) => {
    if (!isEditing.value) {
        form.slug = newValue
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
});
</script> 