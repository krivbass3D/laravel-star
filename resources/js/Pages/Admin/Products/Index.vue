<template>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Products</h1>
            <button @click="openCreateModal" class="bg-blue-500 text-white px-4 py-2 rounded">
                Add new Product
            </button>
        </div>

        <div class="mb-4 flex gap-4">
            <select v-model="perPage" class="border rounded p-2">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
            </select>
            <input v-model="search" type="text" placeholder="Search by name..." class="border rounded p-2 flex-grow">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products.data" :key="product.id">
                        <td class="border px-4 py-2">{{ product.id }}</td>
                        <td class="border px-4 py-2">
                            <img :src="product.image" alt="Product image" class="w-16 h-16 object-cover">
                        </td>
                        <td class="border px-4 py-2">{{ product.title }}</td>
                        <td class="border px-4 py-2">${{ product.price }}</td>
                        <td class="border px-4 py-2">{{ product.category?.name || 'No Category' }}</td>
                        <td class="border px-4 py-2">
                            <span :class="{'text-green-600': product.is_active, 'text-red-600': !product.is_active}">
                                {{ product.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="border px-4 py-2">
                            <button @click="editProduct(product)" class="bg-blue-500 text-white px-2 py-1 rounded mr-2">
                                Edit
                            </button>
                            <button @click="deleteProduct(product.id)" class="bg-red-500 text-white px-2 py-1 rounded">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Pagination :links="products.links" :meta="products.meta" class="mt-4" />

        <Modal :show="showModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium mb-4">{{ isEditing ? 'Edit Product' : 'Create Product' }}</h2>
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block mb-1">Title</label>
                        <input v-model="form.title" type="text" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block mb-1">Price</label>
                        <input v-model="form.price" type="number" step="0.01" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block mb-1">Category</label>
                        <select v-model="form.category_id" class="w-full border rounded p-2">
                            <option value="">Select Category</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1">Description</label>
                        <textarea v-model="form.description" class="w-full border rounded p-2" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block mb-1">Image</label>
                        <input type="file" @change="handleImageUpload" accept="image/*" class="w-full border rounded p-2">
                    </div>
                    <div class="flex items-center">
                        <input v-model="form.is_active" type="checkbox" class="mr-2">
                        <label>Active</label>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                            {{ isEditing ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    products: Object,
    categories: Array
});

const showModal = ref(false);
const isEditing = ref(false);
const perPage = ref(10);
const search = ref('');

const form = ref({
    title: '',
    description: '',
    price: '',
    category_id: '',
    image: null,
    is_active: true
});

const openCreateModal = () => {
    isEditing.value = false;
    form.value = {
        title: '',
        description: '',
        price: '',
        category_id: '',
        image: null,
        is_active: true
    };
    showModal.value = true;
};

const editProduct = (product) => {
    isEditing.value = true;
    form.value = {
        title: product.title,
        description: product.description,
        price: product.price,
        category_id: product.category_id,
        is_active: product.is_active
    };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.value = {
        title: '',
        description: '',
        price: '',
        category_id: '',
        image: null,
        is_active: true
    };
};

const handleImageUpload = (e) => {
    const file = e.target.files[0];
    form.value.image = file;
};

const submitForm = () => {
    if (isEditing.value) {
        router.post(`/admin/products/${form.value.id}`, {
            ...form.value,
            _method: 'PUT'
        }, {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
            }
        });
    } else {
        router.post('/admin/products', form.value, {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
            }
        });
    }
};

const deleteProduct = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(`/admin/products/${id}`, {
            preserveScroll: true
        });
    }
};

watch([perPage, search], () => {
    router.get('/admin/products', {
        perPage: perPage.value,
        search: search.value
    }, {
        preserveScroll: true,
        preserveState: true
    });
});
</script> 