<script setup>
import { Link } from '@inertiajs/vue3';
import { useCartStore } from '../Stores/cartStore';
import { ROUTES } from '../constants/routes';
import ShopLayout from '@/Layouts/ShopLayout.vue';

const cart = useCartStore();
</script>

<template>
    <ShopLayout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
                
                <Link :href="ROUTES.HOME" class="mt-4 inline-block text-purple-600 hover:text-purple-800">
                    ← Continue Shopping
                </Link>

                <div v-if="cart.items.length === 0" class="mt-8 text-center">
                    <p class="text-gray-500">Your cart is empty</p>
                </div>

                <div v-else class="mt-8">
                    <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                            <li v-for="item in cart.items" :key="item.id" class="py-6 flex">
                                <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-center object-cover">
                                </div>

                                <div class="ml-4 flex-1 flex flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>{{ item.name }}</h3>
                                            <p class="ml-4">${{ item.price }}</p>
                                        </div>
                                    </div>
                                    <div class="flex-1 flex items-end justify-between text-sm">
                                        <p class="text-gray-500">Qty {{ item.quantity }}</p>
                                        <div class="flex">
                                            <button @click="cart.removeItem(item.id)" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <p>Subtotal</p>
                            <p>${{ cart.totalPrice }}</p>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                        <div class="mt-6">
                            <Link :href="ROUTES.CHECKOUT" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
                                Checkout
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template> 