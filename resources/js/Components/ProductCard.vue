<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="relative pb-[75%]">
            <img :src="product.image || '/images/placeholder.jpg'" 
                :alt="product.name"
                class="absolute top-0 left-0 w-full h-full object-cover">
        </div>
        <div class="p-4">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-semibold text-gray-900 truncate">
                    {{ product.name }}
                </h3>
                <span class="text-lg font-bold text-indigo-600">
                    {{ formatPrice(product.price) }}
                </span>
            </div>
            <p class="text-sm text-gray-600 line-clamp-2 mb-2">
                {{ product.description }}
            </p>
            <div class="flex items-center justify-between">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    {{ product.category.name }}
                </span>
                <button @click="$emit('add-to-cart', product)"
                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    В корзину
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: true
    }
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB'
    }).format(price);
};
</script> 