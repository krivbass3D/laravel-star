<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Регистрация
                </h2>
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="name" class="sr-only">Имя</label>
                        <input id="name" v-model="form.name" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Имя">
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" v-model="form.email" type="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Пароль</label>
                        <input id="password" v-model="form.password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Пароль">
                    </div>
                    <div>
                        <label for="password_confirmation" class="sr-only">Подтверждение пароля</label>
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Подтверждение пароля">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Зарегистрироваться
                    </button>
                </div>

                <div class="text-center">
                    <router-link to="/login" class="text-indigo-600 hover:text-indigo-500">
                        Уже есть аккаунт? Войти
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../Stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const handleRegister = async () => {
    try {
        await authStore.register(form.value);
        router.push('/');
    } catch (error) {
        console.error('Ошибка регистрации:', error);
    }
};
</script> 