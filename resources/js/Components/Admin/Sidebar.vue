<template>
    <div class="min-h-screen bg-indigo-600 text-white w-64 flex flex-col transition-all duration-300"
         :class="{ 'w-64': !isCollapsed, 'w-16': isCollapsed }">
        <div class="p-4 flex items-center justify-between">
            <router-link to="/admin" class="flex items-center space-x-2" v-show="!isCollapsed">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xl font-semibold">Dashboard</span>
            </router-link>
            <button @click="toggleSidebar" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-2 py-4">
            <Link :href="ROUTES.ADMIN.DASHBOARD" 
                  class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-700 transition-colors"
                  :class="{ 'justify-center': isCollapsed }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span v-show="!isCollapsed">Dashboard</span>
            </Link>

            <Link :href="ROUTES.ADMIN.CATEGORIES" 
                  class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-700 transition-colors mt-2"
                  :class="{ 'justify-center': isCollapsed }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span v-show="!isCollapsed">Categories</span>
            </Link>

            <Link :href="ROUTES.ADMIN.PRODUCTS" 
                  class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-700 transition-colors mt-2"
                  :class="{ 'justify-center': isCollapsed }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span v-show="!isCollapsed">Products</span>
            </Link>

            <Link :href="ROUTES.ADMIN.ORDERS" 
                  class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-700 transition-colors mt-2"
                  :class="{ 'justify-center': isCollapsed }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span v-show="!isCollapsed">Orders</span>
            </Link>

            <Link :href="ROUTES.ADMIN.USERS" 
                  class="flex items-center space-x-2 p-2 rounded-lg hover:bg-indigo-700 transition-colors mt-2"
                  :class="{ 'justify-center': isCollapsed }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span v-show="!isCollapsed">Users</span>
            </Link>
        </nav>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ROUTES } from '@/constants/routes';

const isCollapsed = ref(false);

const toggleSidebar = () => {
    isCollapsed.value = !isCollapsed.value;
};
</script> 