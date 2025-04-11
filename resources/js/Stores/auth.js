import { defineStore } from 'pinia';
import api from '../axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('auth_token') || null,
        isAuthenticated: !!localStorage.getItem('auth_token')
    }),

    actions: {
        async login(credentials) {
            try {
                const response = await api.post('/auth/login', credentials);
                this.token = response.data.access_token;
                this.user = response.data.user;
                this.isAuthenticated = true;
                localStorage.setItem('auth_token', this.token);
                return response;
            } catch (error) {
                throw error;
            }
        },

        async register(userData) {
            try {
                const response = await api.post('/auth/register', userData);
                this.token = response.data.access_token;
                this.user = response.data.user;
                this.isAuthenticated = true;
                localStorage.setItem('auth_token', this.token);
                return response;
            } catch (error) {
                throw error;
            }
        },

        async logout() {
            try {
                await api.post('/auth/logout');
                this.token = null;
                this.user = null;
                this.isAuthenticated = false;
                localStorage.removeItem('auth_token');
            } catch (error) {
                throw error;
            }
        },

        async fetchUser() {
            try {
                const response = await api.get('/user');
                this.user = response.data;
                return response;
            } catch (error) {
                throw error;
            }
        }
    }
}); 