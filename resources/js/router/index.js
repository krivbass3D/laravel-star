import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../Stores/auth';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../Pages/HomeView.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../Pages/Auth/LoginView.vue'),
        meta: { guest: true }
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('../Pages/Auth/RegisterView.vue'),
        meta: { guest: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const isGuest = to.matched.some(record => record.meta.guest);

    if (requiresAuth && !authStore.isAuthenticated) {
        next('/login');
    } else if (isGuest && authStore.isAuthenticated) {
        next('/');
    } else {
        next();
    }
});

export default router; 