<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const stats = ref([
    { name: 'Total Products', value: '0', change: '+0%', changeType: 'positive' },
    { name: 'Total Orders', value: '0', change: '+0%', changeType: 'positive' },
    { name: 'Total Users', value: '0', change: '+0%', changeType: 'positive' },
    { name: 'Total Revenue', value: '$0', change: '+0%', changeType: 'positive' }
]);

const latestCustomers = ref([
    {
        name: 'John Smith',
        email: 'user2@example.com'
    },
    {
        name: 'John Doe',
        email: 'user1@example.com'
    },
    {
        name: 'Zura',
        email: 'zurasekhnishvili@gmail.com'
    }
]);

defineOptions({
    layout: AdminLayout
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="p-6 bg-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
            <div class="flex items-center">
                <span class="mr-2">Change Date Period</span>
                <select class="border rounded-md p-1">
                    <option>All Time</option>
                    <option>This Month</option>
                    <option>This Year</option>
                </select>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Active Customers</h3>
                <p class="text-3xl font-bold">3</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Active Products</h3>
                <p class="text-3xl font-bold">6</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Paid Orders</h3>
                <p class="text-3xl font-bold">0</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-600 mb-2">Total Income</h3>
                <p class="text-3xl font-bold">$0</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Latest Orders -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Latest Orders</h2>
                <div class="overflow-x-auto">
                    <!-- Add table here when there are orders -->
                    <p class="text-gray-500">No orders yet</p>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Orders by Country -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Orders by Country</h2>
                    <!-- Add chart here when there are orders -->
                    <p class="text-gray-500">No data available</p>
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
    </div>
</template>

<style scoped>
.dashboard-card {
    @apply bg-white p-6 rounded-lg shadow;
}
</style> 