<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    stats: {
        type: Object,
        required: true,
        default: () => ({
            users: 0,
            products: 0,
            orders: 0,
            total_income: 0
        })
    },
    latestOrders: {
        type: Array,
        required: true,
        default: () => []
    },
    latestCustomers: {
        type: Array,
        required: true,
        default: () => []
    }
});

defineOptions({
    layout: AdminLayout
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="p-6 bg-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Active Customers</h3>
                <p class="text-3xl font-bold">{{ stats.users }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Active Products</h3>
                <p class="text-3xl font-bold">{{ stats.products }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Total Orders</h3>
                <p class="text-3xl font-bold">{{ stats.orders }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Total Income</h3>
                <p class="text-3xl font-bold">${{ stats.total_income }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Latest Orders -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Latest Orders</h2>
                <div class="overflow-x-auto">
                    <table v-if="latestOrders?.length" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Order ID</th>
                                <th class="px-4 py-2 text-left">Customer</th>
                                <th class="px-4 py-2 text-left">Items</th>
                                <th class="px-4 py-2 text-left">Total</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in latestOrders" :key="order.id" class="hover:bg-gray-50">
                                <td class="px-4 py-2">#{{ order.id }}</td>
                                <td class="px-4 py-2">
                                    <div>{{ order.name }}</div>
                                    <div class="text-sm text-gray-500">{{ order.email }}</div>
                                </td>
                                <td class="px-4 py-2">
                                    <div v-for="item in order.items" :key="item.product_title" class="text-sm">
                                        {{ item.product_title }} (x{{ item.quantity }})
                                    </div>
                                </td>
                                <td class="px-4 py-2">${{ order.total_amount }}</td>
                                <td class="px-4 py-2">
                                    <span :class="{
                                        'px-2 py-1 rounded-full text-xs font-semibold': true,
                                        'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                        'bg-blue-100 text-blue-800': order.status === 'processing',
                                        'bg-green-100 text-green-800': order.status === 'completed',
                                        'bg-red-100 text-red-800': order.status === 'cancelled'
                                    }">
                                        {{ order.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ order.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p v-else class="text-gray-500">No orders yet</p>
                </div>
            </div>

            <!-- Latest Customers -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Latest Customers</h2>
                <div class="space-y-4">
                    <div v-for="customer in latestCustomers" :key="customer.email" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium">{{ customer.name }}</p>
                            <p class="text-sm text-gray-600">{{ customer.email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.dashboard-card {
    @apply bg-white p-6 rounded-lg shadow;
}
</style> 