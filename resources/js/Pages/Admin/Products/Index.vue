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
                        <span v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</span>
                    </div>
                    <div>
                        <label class="block mb-1">Price</label>
                        <input v-model="form.price" type="number" step="0.01" class="w-full border rounded p-2">
                        <span v-if="errors.price" class="text-red-500 text-sm">{{ errors.price }}</span>
                    </div>
                    <div>
                        <label class="block mb-1">Category</label>
                        <select v-model="form.category_id" class="w-full border rounded p-2">
                            <option value="">Select Category</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <span v-if="errors.category_id" class="text-red-500 text-sm">{{ errors.category_id }}</span>
                    </div>
                    <div>
                        <label class="block mb-1">Description</label>
                        <textarea v-model="form.description" class="w-full border rounded p-2" rows="3"></textarea>
                        <span v-if="errors.description" class="text-red-500 text-sm">{{ errors.description }}</span>
                    </div>
                    <div>
                        <label class="block mb-1">Image{{ !isEditing ? ' *' : '' }}</label>
                        <input type="file" @change="handleImageUpload" accept="image/*" class="w-full border rounded p-2">
                        <span v-if="errors.image" class="text-red-500 text-sm">{{ errors.image }}</span>
                        <span v-if="!isEditing" class="text-gray-500 text-sm">Image is required for new products</span>
                    </div>
                    <div class="flex items-center">
                        <input v-model="form.is_active" type="checkbox" class="mr-2">
                        <label>Active</label>
                        <span v-if="errors.is_active" class="text-red-500 text-sm ml-2">{{ errors.is_active }}</span>
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
import { ref, onMounted, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { ROUTES } from '@/constants/routes';

defineOptions({
    layout: AdminLayout
});

const props = defineProps({
    products: {
        type: Object,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
});

const showModal = ref(false);
const isEditing = ref(false);
const perPage = ref(10);
const search = ref('');

const form = ref({
    id: null,
    title: '',
    slug: '',
    description: '',
    price: '',
    category_id: '',
    image: null,
    is_active: true
});

const errors = ref({});

// Функция для поиска slug категории по её id
const getCategorySlug = (categoryId) => {
    const category = props.categories.find(cat => cat.id.toString() === categoryId.toString());
    return category ? category.slug : '';
};

// Следим за изменением category_id и генерируем slug из slug категории
watch(() => form.value.category_id, (newCategoryId) => {
    if (newCategoryId) {
        form.value.slug = getCategorySlug(newCategoryId);
    }
});

const openCreateModal = () => {
    isEditing.value = false;
    form.value = {
        id: null,
        title: '',
        slug: '',
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
        id: product.id,
        title: product.title,
        slug: getCategorySlug(product.category_id), // Используем slug категории
        description: product.description,
        price: product.price,
        category_id: product.category_id?.toString() || '',
        is_active: Boolean(product.is_active),
        image: null
    };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    isEditing.value = false;
    errors.value = {};
    form.value = {
        id: null,
        title: '',
        slug: '',
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
    errors.value = {};

    const formData = new FormData();
    
    // Получаем slug категории
    const categorySlug = getCategorySlug(form.value.category_id);
    if (!categorySlug) {
        errors.value.category_id = 'Category is required';
        return;
    }

    const formValues = {
        ...form.value,
        category_id: form.value.category_id ? parseInt(form.value.category_id) : null,
        is_active: Boolean(form.value.is_active),
        slug: categorySlug // Добавляем slug в formValues
    };

    if (!isEditing.value && !form.value.image) {
        errors.value.image = 'The image field is required';
        return;
    }
    
    // Сначала добавляем slug, чтобы убедиться, что он будет в запросе
    formData.append('slug', formValues.slug);
    
    // Затем добавляем остальные поля
    Object.keys(formValues).forEach(key => {
        if (formValues[key] !== null && key !== 'slug') { // Пропускаем slug, так как уже добавили
            if (key === 'image' && formValues[key] instanceof File) {
                formData.append(key, formValues[key]);
            } else if (key === 'is_active') {
                formData.append(key, formValues[key] ? '1' : '0');
            } else if (key !== 'image') {
                formData.append(key, formValues[key]);
            }
        }
    });

    if (isEditing.value) {
        formData.append('_method', 'PUT');
        router.post(`/admin/products/${form.value.id}`, formData, {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                errors.value = {};
            },
            onError: (validationErrors) => {
                errors.value = validationErrors;
                console.error('Update errors:', validationErrors);
            }
        });
    } else {
        router.post('/admin/products', formData, {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                errors.value = {};
            },
            onError: (validationErrors) => {
                errors.value = validationErrors;
                console.error('Create errors:', validationErrors);
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

watch([perPage, search], ([newPerPage, newSearch]) => {
    router.get(ROUTES.ADMIN.PRODUCTS, {
        per_page: newPerPage,
        search: newSearch
    }, {
        preserveState: true,
        preserveScroll: true
    });
});
</script> 