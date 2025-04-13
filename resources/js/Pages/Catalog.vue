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
                           v-model="searchQuery"
                           @input="handleSearch"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select class="ml-4 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            v-model="sortOption"
                            @change="handleSort">
                        <option value="newest">Last Modified at the top</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Фильтры -->
            <div class="mb-8 bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Filters</h2>
                
                <!-- Фильтр по цене -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Price (€{{ priceFilter.min.toFixed(2) }} - €{{ priceFilter.max.toFixed(2) }})
                    </label>
                    <div class="relative w-full h-2 bg-gray-200 rounded mt-6 mb-6">
                        <!-- Полоса выбранного диапазона -->
                        <div 
                            class="absolute h-full bg-purple-500"
                            :style="{
                                left: `${((priceFilter.min - priceRange.min) / (priceRange.max - priceRange.min)) * 100}%`,
                                right: `${100 - ((priceFilter.max - priceRange.min) / (priceRange.max - priceRange.min)) * 100}%`
                            }"
                        ></div>
                        
                        <!-- Левый ползунок -->
                        <div 
                            class="absolute w-4 h-4 bg-white border-2 border-purple-500 rounded-full -mt-1.5 transform -translate-x-1/2 cursor-pointer hover:scale-110 transition-transform"
                            :style="{
                                left: `${((priceFilter.min - priceRange.min) / (priceRange.max - priceRange.min)) * 100}%`
                            }"
                        ></div>
                        
                        <!-- Правый ползунок -->
                        <div 
                            class="absolute w-4 h-4 bg-white border-2 border-purple-500 rounded-full -mt-1.5 transform -translate-x-1/2 cursor-pointer hover:scale-110 transition-transform"
                            :style="{
                                left: `${((priceFilter.max - priceRange.min) / (priceRange.max - priceRange.min)) * 100}%`
                            }"
                        ></div>
                        
                        <!-- Скрытые инпуты для функциональности -->
                        <input 
                            type="range" 
                            v-model.number="priceFilter.min" 
                            :min="priceRange.min" 
                            :max="priceRange.max"
                            :step="0.01"
                            class="range-input range-input-min"
                            @input="updatePriceFilter"
                            @change="applyPriceFilter"
                        >
                        <input 
                            type="range" 
                            v-model.number="priceFilter.max" 
                            :min="priceRange.min" 
                            :max="priceRange.max"
                            :step="0.01"
                            class="range-input range-input-max"
                            @input="updatePriceFilter"
                            @change="applyPriceFilter"
                        >
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-sm text-gray-600">€{{ priceFilter.min.toFixed(2) }}</span>
                        <span class="text-sm text-gray-600">€{{ priceFilter.max.toFixed(2) }}</span>
                    </div>
                </div>

                <!-- Сортировка -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort by</label>
                    <select 
                        v-model="sortOption" 
                        @change="handleSort"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    >
                        <option value="newest">Last Modified at the top</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>

                <!-- Кнопка сброса фильтров -->
                <button 
                    @click="clearFilters"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300"
                >
                    Reset Filters
                </button>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div v-for="product in products.data" :key="product.id" 
                     class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <img :src="product.image" :alt="product.title" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ product.title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ product.description }}</p>
                        <p class="text-gray-900 font-medium">€{{ product.price }}</p>
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
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useCartStore } from '@/Stores/cartStore';
import { ROUTES } from '../constants/routes';

const showMoreCategories = ref(false);
const searchQuery = ref('');
const searchTimeout = ref(null);
const sortOption = ref('newest');

const props = defineProps({
    categories: Array,
    products: Object,
    filters: Object,
    priceRange: Object
});

const priceFilter = ref({
    min: props.priceRange.min,
    max: props.priceRange.max
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
    if (props.filters.search) {
        searchQuery.value = props.filters.search;
    }
    if (props.filters.sort) {
        sortOption.value = props.filters.sort;
    }
    if (props.filters.min_price) {
        priceFilter.value.min = Number(props.filters.min_price);
    }
    if (props.filters.max_price) {
        priceFilter.value.max = Number(props.filters.max_price);
    }
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
    showMoreCategories.value = false;
    router.get(route('home'), { 
        ...props.filters,
        category: categoryId 
    }, {
        preserveState: true,
        preserveScroll: true
    });
};

// Обработчик изменения значений слайдера
const updatePriceFilter = () => {
    // Проверяем, чтобы минимальная цена не была больше максимальной
    if (priceFilter.value.min > priceFilter.value.max) {
        if (priceFilter.value.min > props.priceRange.max) {
            priceFilter.value.min = props.priceRange.max;
        }
        priceFilter.value.max = priceFilter.value.min;
    }
};

// Применяем фильтр только когда пользователь отпускает ползунок
const applyPriceFilter = () => {
    router.get(route('home'), {
        ...props.filters,
        min_price: priceFilter.value.min,
        max_price: priceFilter.value.max
    }, {
        preserveState: true,
        preserveScroll: true
    });
};

const clearFilters = () => {
    priceFilter.value = {
        min: props.priceRange.min,
        max: props.priceRange.max
    };
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

const handleSort = () => {
    router.get(route('home'), { 
        ...props.filters,
        sort: sortOption.value 
    }, {
        preserveState: true,
        preserveScroll: true
    });
};

const handleSearch = () => {
    clearTimeout(searchTimeout.value);
    searchTimeout.value = setTimeout(() => {
        router.get(route('home'), { 
            search: searchQuery.value,
            sort: sortOption.value 
        }, {
            preserveState: true,
            preserveScroll: true
        });
    }, 300);
};
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.range-input {
    -webkit-appearance: none;
    pointer-events: none;
    position: absolute;
    width: 100%;
    height: 100%;
    background: none;
    top: 0;
    left: 0;
    margin: 0;
    z-index: 3;
}

.range-input::-webkit-slider-thumb {
    -webkit-appearance: none;
    pointer-events: auto;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: transparent;
    cursor: pointer;
    border: none;
    margin-top: -4px;
    position: relative;
    z-index: 4;
}

.range-input::-moz-range-thumb {
    pointer-events: auto;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: transparent;
    cursor: pointer;
    border: none;
    margin-top: -4px;
    position: relative;
    z-index: 4;
}

.range-input::-webkit-slider-runnable-track,
.range-input::-moz-range-track {
    width: 100%;
    height: 100%;
    background: none;
    border: none;
}

.range-input-min {
    z-index: 4;
}

.range-input-max {
    z-index: 3;
}
</style> 