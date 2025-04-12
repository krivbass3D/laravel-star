<template>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
        
        <div v-if="cartStore.items.length === 0" class="text-center py-12">
            <p class="text-gray-600">Your cart is empty</p>
        </div>
        
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div v-for="item in cartStore.items" :key="item.id" class="bg-white rounded-lg shadow p-6 mb-4">
                    <div class="flex items-center">
                        <img :src="item.image" :alt="item.name" class="w-20 h-20 object-cover rounded">
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold">{{ item.name }}</h3>
                            <p class="text-gray-600">${{ item.price }}</p>
                        </div>
                        <div class="flex items-center">
                            <button @click="updateQuantity(item.id, item.quantity - 1)" class="px-3 py-1 border rounded">-</button>
                            <span class="mx-4">{{ item.quantity }}</span>
                            <button @click="updateQuantity(item.id, item.quantity + 1)" class="px-3 py-1 border rounded">+</button>
                            <button @click="removeFromCart(item.id)" class="ml-4 text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>${{ cartStore.totalPrice.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="border-t pt-4">
                            <div class="flex justify-between font-bold">
                                <span>Total</span>
                                <span>${{ cartStore.totalPrice.toFixed(2) }}</span>
                            </div>
                        </div>
                        <button @click="proceedToCheckout" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useCartStore } from '@/Stores/cartStore';
import { useRouter } from 'vue-router';

const cartStore = useCartStore();
const router = useRouter();

const updateQuantity = (productId, quantity) => {
    cartStore.updateQuantity(productId, quantity);
};

const removeFromCart = (productId) => {
    cartStore.removeFromCart(productId);
};

const proceedToCheckout = () => {
    router.push('/checkout');
};
</script> 