<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <header class="bg-gray-900 text-white">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-4">
                    <!-- Logo -->
                    <div class="text-xl font-bold">Logo</div>
                    
                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center space-x-8">
                        <!-- Основные категории (первые 5) -->
                        <template v-for="(category, index) in categories.slice(0, 5)" :key="category.id">
                            <a href="#"
                               @click.prevent="filterByCategory(category.id)"
                               class="hover:text-gray-300"
                               :class="{ 'text-blue-400': filters.category == category.id }">
                                {{ category.name }}
                            </a>
                        </template>

                        <!-- Выпадающее меню для остальных категорий -->
                        <div class="relative" v-if="categories.length > 5">
                            <button @click="showMoreCategories = !showMoreCategories"
                                    class="flex items-center hover:text-gray-300 focus:outline-none">
                                Ещё
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <!-- Выпадающий список -->
                            <div v-show="showMoreCategories"
                                 class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-50">
                                <a v-for="category in categories.slice(5)" 
                                   :key="category.id"
                                   href="#"
                                   @click.prevent="filterByCategory(category.id)"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   :class="{ 'bg-blue-50 text-blue-600': filters.category == category.id }">
                                    {{ category.name }}
                                </a>
                            </div>
                        </div>
                    </nav>

                    <!-- Cart and Auth -->
                    <div class="flex items-center space-x-4">
                        <Link :href="ROUTES.CART" class="flex items-center hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="ml-1">Cart</span>
                            <span v-if="cart.totalItems > 0" class="ml-1 bg-red-500 rounded-full px-2 text-sm">
                                {{ cart.totalItems }}
                            </span>
                        </Link>
                        <template v-if="!$page.props.auth.user">
                            <Link :href="ROUTES.LOGIN" class="hover:text-gray-300">
                                Login
                            </Link>
                            <Link :href="ROUTES.REGISTER" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md">
                                Register now
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="ROUTES.DASHBOARD" class="hover:text-gray-300">
                                Dashboard
                            </Link>
                            <button @click="logout" class="hover:text-gray-300">
                                Logout
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <!-- Search Bar -->
        <div class="bg-white shadow">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <input type="text" 
                           placeholder="Search for the products" 
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select class="ml-4 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Last Modified at the top</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div v-for="product in products.data" :key="product.id" 
                     class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ product.name }}</h3>
                        <p class="text-gray-600">€{{ product.price }}</p>
                        <button @click="addToCart(product)" 
                                class="mt-4 w-full bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <Pagination :links="products.links" />
            </div>
        </main>
    </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useCartStore } from '@/Stores/cartStore';
import { ROUTES } from '../constants/routes';

const showMoreCategories = ref(false);

const props = defineProps({
    categories: Array,
    products: Object,
    filters: Object
});

const cart = useCartStore();

// Закрываем выпадающее меню при клике вне его
const closeMoreCategories = (e) => {
    if (!e.target.closest('.relative')) {
        showMoreCategories.value = false;
    }
};

// Добавляем слушатель событий при монтировании компонента
onMounted(() => {
    document.addEventListener('click', closeMoreCategories);
});

// Удаляем слушатель при размонтировании
onUnmounted(() => {
    document.removeEventListener('click', closeMoreCategories);
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'EUR'
    }).format(price);
};

const filterByCategory = (categoryId) => {
    showMoreCategories.value = false; // Закрываем меню при выборе категории
    router.get(route('home'), { category: categoryId }, {
        preserveState: true,
        preserveScroll: true
    });
};

const clearFilters = () => {
    router.get(route('home'), {}, {
        preserveState: true,
        preserveScroll: true
    });
};

const logout = () => {
    router.post(route('logout'));
};

const addToCart = (product) => {
    cart.addToCart(product);
    // Добавим уведомление об успешном добавлении
    alert('Product added to cart!');
};
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style> 