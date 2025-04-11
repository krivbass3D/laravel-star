<template>
    <div class="min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 p-4">
                    <h1 class="text-2xl font-bold mb-4">Добро пожаловать!</h1>
                    <p class="text-gray-600">Вы успешно авторизованы.</p>
                    <button @click="handleLogout" class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Выйти
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../Stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const handleLogout = async () => {
    try {
        await authStore.logout();
        router.push('/login');
    } catch (error) {
        console.error('Ошибка выхода:', error);
    }
};
</script> 