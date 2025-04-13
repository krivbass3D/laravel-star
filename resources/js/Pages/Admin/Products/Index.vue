<template>
    <div class="min-h-screen bg-gray-100">
        <AdminLayout>
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">Products</h1>
                        <button @click="openCreateModal" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Add new Product
                        </button>
                    </div>

                    <!-- Filters -->
                    <div class="mb-4 flex items-center space-x-4">
                        <div class="flex items-center">
                            <span class="mr-2">Per Page:</span>
                            <select v-model="perPage" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <input type="text" v-model="search" placeholder="Search products..." 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated At</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="product in products.data" :key="product.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img :src="'/storage/' + product.image" class="h-12 w-12 object-cover rounded-md" :alt="product.title">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ product.price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.last_updated_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="editProduct(product)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                        <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        <Pagination :links="products.meta.links" />
                    </div>
                </div>
            </div>

            <!-- Create/Edit Modal -->
            <Modal :show="showModal" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        {{ isEditing ? 'Edit Product' : 'Create New Product' }}
                    </h2>
                    <form @submit.prevent="submitForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" v-model="form.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="number" step="0.01" v-model="form.price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" v-model="form.quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" @change="handleImageUpload" accept="image/*" class="mt-1 block w-full">
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="closeModal" class="bg-gray-50 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100">
                                Cancel
                            </button>
                            <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-md text-white hover:bg-indigo-700">
                                {{ isEditing ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </Modal>
        </AdminLayout>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
});

const showModal = ref(false);
const isEditing = ref(false);
const perPage = ref(10);
const search = ref('');
const form = ref({
    name: '',
    price: '',
    quantity: '',
    image: null,
});

const openCreateModal = () => {
    isEditing.value = false;
    form.value = {
        name: '',
        price: '',
        quantity: '',
        image: null,
    };
    showModal.value = true;
};

const editProduct = (product) => {
    isEditing.value = true;
    form.value = {
        name: product.title,
        price: product.price,
        quantity: product.quantity,
        image: null,
    };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.value = {
        name: '',
        price: '',
        quantity: '',
        image: null,
    };
};

const handleImageUpload = (e) => {
    form.value.image = e.target.files[0];
};

const submitForm = () => {
    if (isEditing.value) {
        router.post(`/admin/products/${form.value.id}`, {
            _method: 'PUT',
            ...form.value
        }, {
            onSuccess: () => {
                closeModal();
            },
        });
    } else {
        router.post('/admin/products', form.value, {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

const deleteProduct = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(`/admin/products/${id}`);
    }
};

watch([perPage, search], () => {
    router.get('/admin/products', {
        per_page: perPage.value,
        search: search.value,
    }, { preserveState: true });
});
</script> 