<script setup>
import { Link } from '@inertiajs/vue3';
import { useCartStore } from '../Stores/cartStore';
import { ROUTES } from '../constants/routes';

const cart = useCartStore();
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <header class="bg-gray-900 text-white">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-4">
                    <!-- Logo -->
                    <div class="text-xl font-bold">
                        <Link :href="ROUTES.HOME" class="text-white hover:text-gray-300">
                            E-Shop
                        </Link>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center space-x-8">
                        <Link :href="ROUTES.HOME" class="hover:text-gray-300">
                            Home
                        </Link>
                        <Link :href="ROUTES.CATALOG" class="hover:text-gray-300">
                            Catalog
                        </Link>
                    </nav>

                    <!-- Cart and Auth -->
                    <div class="flex items-center space-x-4">
                        <Link :href="ROUTES.CART" class="flex items-center hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="ml-1">Cart</span>
                            <span v-if="cart.totalItems > 0" class="ml-1 bg-red-500 rounded-full px-2 text-sm">
                                {{ cart.totalItems }}
                            </span>
                        </Link>
                        <template v-if="!$page.props.auth.user">
                            <Link :href="ROUTES.LOGIN" class="hover:text-gray-300">
                                Login
                            </Link>
                            <Link :href="ROUTES.REGISTER" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md">
                                Register now
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="ROUTES.DASHBOARD" class="hover:text-gray-300">
                                Dashboard
                            </Link>
                            <Link :href="ROUTES.LOGOUT" method="post" as="button" class="hover:text-gray-300">
                                Logout
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <slot />
        </main>
    </div>
</template> 