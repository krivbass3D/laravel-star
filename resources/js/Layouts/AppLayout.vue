<template>
    <div class="min-h-screen bg-gray-100">
        <div class="flex">
            <AdminSidebar />
            
            <div class="flex-1">
                <nav class="bg-white border-b border-gray-200">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <div class="flex-shrink-0 flex items-center">
                                    <h1 class="text-xl font-semibold">Admin Panel</h1>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="ml-3 relative">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-gray-700">Admin</span>
                                        <img class="h-8 w-8 rounded-full" 
                                             src="https://ui-avatars.com/api/?name=Admin&amp;color=7F9CF5&amp;background=EBF4FF" 
                                             alt="Admin">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <main class="flex-1">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useCartStore } from '../Stores/cartStore';
import { ROUTES } from '../constants/routes';
import AdminSidebar from '@/Components/Admin/Sidebar.vue';

const cart = useCartStore();
</script> 