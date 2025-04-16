<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Orders</h2>
                        <div class="flex items-center space-x-4">
                            <select v-model="perPage" class="rounded-md border-gray-300 shadow-sm">
                                <option value="10">10 per page</option>
                                <option value="25">25 per page</option>
                                <option value="50">50 per page</option>
                            </select>
                            <input
                                type="text"
                                v-model="search"
                                placeholder="Search by name, email or phone..."
                                class="rounded-md border-gray-300 shadow-sm w-80"
                            >
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">ID</th>
                                    <th class="px-4 py-2">Customer</th>
                                    <th class="px-4 py-2">Contact</th>
                                    <th class="px-4 py-2">Items</th>
                                    <th class="px-4 py-2">Total</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders.data" :key="order.id" class="border-t">
                                    <td class="border px-4 py-2">#{{ order.id }}</td>
                                    <td class="border px-4 py-2">
                                        <div>{{ order.name }}</div>
                                        <div class="text-sm text-gray-500">{{ order.address }}, {{ order.city }}</div>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <div>{{ order.email }}</div>
                                        <div>{{ order.phone }}</div>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <div v-for="item in order.items" :key="item.id" class="text-sm">
                                            {{ item.product.title }} (x{{ item.quantity }})
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2">${{ order.total_amount }}</td>
                                    <td class="border px-4 py-2">
                                        <select 
                                            v-model="order.status"
                                            @change="updateOrderStatus(order)"
                                            class="rounded border-gray-300 text-sm"
                                            :class="{
                                                'bg-yellow-100': order.status === 'pending',
                                                'bg-blue-100': order.status === 'processing',
                                                'bg-green-100': order.status === 'completed',
                                                'bg-red-100': order.status === 'cancelled'
                                            }"
                                        >
                                            <option value="pending">Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ new Date(order.created_at).toLocaleDateString() }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button @click="deleteOrder(order.id)" class="bg-red-500 text-white px-2 py-1 rounded">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="orders.links" class="mt-4" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

defineOptions({
    layout: AdminLayout
});

const props = defineProps({
    orders: {
        type: Object,
        required: true
    }
});

const perPage = ref(10);
const search = ref('');

watch([perPage, search], ([newPerPage, newSearch], [oldPerPage, oldSearch]) => {
    if (newPerPage !== oldPerPage || newSearch !== oldSearch) {
        router.get(
            route('admin.orders.index'),
            { per_page: newPerPage, search: newSearch },
            { preserveState: true, preserveScroll: true }
        );
    }
});

const updateOrderStatus = (order) => {
    router.put(route('admin.orders.update', order.id), {
        status: order.status
    }, {
        preserveScroll: true
    });
};

const deleteOrder = (orderId) => {
    if (confirm('Are you sure you want to delete this order?')) {
        router.delete(route('admin.orders.destroy', orderId), {
            preserveScroll: true
        });
    }
};
</script> 