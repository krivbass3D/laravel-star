<template>
    <ShopLayout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>

                <div class="mt-8 grid grid-cols-1 gap-x-8 gap-y-8 lg:grid-cols-2">
                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                        <div class="mt-4 bg-white rounded-lg shadow">
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="item in cart.items" :key="item.id" class="py-6 px-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-16 h-16 border border-gray-200 rounded-md overflow-hidden">
                                            <img :src="item.image" :alt="item.name" class="w-full h-full object-center object-cover">
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>{{ item.name }}</h3>
                                                <p class="ml-4">${{ item.price }}</p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="border-t border-gray-200 py-6 px-4">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Subtotal</p>
                                    <p>${{ cart.totalPrice }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <div class="lg:col-span-1">
                        <h2 class="text-lg font-medium text-gray-900">Shipping Information</h2>
                        <form @submit.prevent="submit" class="mt-4 bg-white rounded-lg shadow p-6">
                            <div class="grid grid-cols-1 gap-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" 
                                           id="name" 
                                           v-model="form.name" 
                                           :readonly="$page.props.auth.user"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                           :class="{ 'bg-gray-100': $page.props.auth.user }">
                                    <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" 
                                           id="email" 
                                           v-model="form.email" 
                                           :readonly="$page.props.auth.user"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                           :class="{ 'bg-gray-100': $page.props.auth.user }">
                                    <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</div>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" 
                                           id="phone" 
                                           v-model="form.phone" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <div v-if="form.errors.phone" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</div>
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" 
                                           id="address" 
                                           v-model="form.address" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <div v-if="form.errors.address" class="mt-1 text-sm text-red-600">{{ form.errors.address }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-x-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" 
                                               id="city" 
                                               v-model="form.city" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <div v-if="form.errors.city" class="mt-1 text-sm text-red-600">{{ form.errors.city }}</div>
                                    </div>

                                    <div>
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                        <input type="text" 
                                               id="postal_code" 
                                               v-model="form.postal_code" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <div v-if="form.errors.postal_code" class="mt-1 text-sm text-red-600">{{ form.errors.postal_code }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                        :disabled="form.processing"
                                        class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                    {{ form.processing ? 'Processing...' : 'Place Order' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { useCartStore } from '../Stores/cartStore';
import { ROUTES } from '../constants/routes';
import ShopLayout from '@/Layouts/ShopLayout.vue';

const cart = useCartStore();

// Получаем данные пользователя из props
const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
});

// Создаем форму с предзаполненными данными пользователя
const form = useForm({
    name: props.auth.user ? props.auth.user.name : '',
    email: props.auth.user ? props.auth.user.email : '',
    phone: props.auth.user ? props.auth.user.phone : '',
    address: props.auth.user ? props.auth.user.address : '',
    city: props.auth.user ? props.auth.user.city : '',
    postal_code: props.auth.user ? props.auth.user.postal_code : '',
    items: cart.items,
    total: cart.totalPrice
});

const submit = () => {
    // Проверяем наличие товаров в корзине
    if (cart.items.length === 0) {
        alert('Your cart is empty');
        return;
    }

    // Преобразуем items в нужный формат
    const formattedItems = cart.items.map(item => ({
        id: item.id,
        quantity: item.quantity,
        price: item.price
    }));

    // Обновляем данные формы перед отправкой
    form.items = formattedItems;
    form.total = cart.totalPrice;

    form.post(route('orders.store'), {
        onSuccess: () => {
            cart.clearCart();
            window.location.href = route('home');
        },
        onError: (errors) => {
            console.error('Order creation failed:', errors);
        }
    });
};
</script> 