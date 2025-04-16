<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        default: () => ({})
    }
});

const user = props.user || {};
</script>

<template>
    <Head title="Dashboard" />

    <ShopLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold">Welcome, {{ user?.name || 'User' }}!</h2>
                            <p class="text-gray-600">Email: {{ user?.email || 'Not set' }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-xl font-semibold mb-2">Your Profile Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p><span class="font-semibold">Phone:</span> {{ user?.phone || 'Not set' }}</p>
                                    <p><span class="font-semibold">Address:</span> {{ user?.address || 'Not set' }}</p>
                                </div>
                                <div>
                                    <p><span class="font-semibold">City:</span> {{ user?.city || 'Not set' }}</p>
                                    <p><span class="font-semibold">Postal Code:</span> {{ user?.postal_code || 'Not set' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-4">
                            <Link 
                                href="/profile"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Edit Profile
                            </Link>

                            <Link 
                                v-if="user?.is_admin"
                                href="/admin"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Admin Panel
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
