import { defineStore } from 'pinia';
import api from '../axios';

export const useCatalogStore = defineStore('catalog', {
    state: () => ({
        products: [],
        categories: [],
        filters: {
            category: null,
            priceRange: {
                min: 0,
                max: Infinity
            }
        },
        loading: false,
        error: null
    }),

    getters: {
        filteredProducts: (state) => {
            return state.products.filter(product => {
                const matchesCategory = !state.filters.category || 
                    product.category.id === state.filters.category;
                const matchesPrice = product.price >= state.filters.priceRange.min && 
                    product.price <= state.filters.priceRange.max;
                return matchesCategory && matchesPrice;
            });
        },
        
        priceRange: (state) => {
            if (!state.products.length) return { min: 0, max: 0 };
            return {
                min: Math.min(...state.products.map(p => p.price)),
                max: Math.max(...state.products.map(p => p.price))
            };
        }
    },

    actions: {
        async fetchProducts() {
            this.loading = true;
            try {
                const response = await api.get('/products');
                this.products = response.data.data;
            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },

        async fetchCategories() {
            try {
                const response = await api.get('/categories');
                this.categories = response.data.data;
            } catch (error) {
                this.error = error.message;
            }
        },

        setFilter(type, value) {
            if (type === 'category') {
                this.filters.category = value;
            } else if (type === 'price') {
                this.filters.priceRange = value;
            }
        },

        resetFilters() {
            this.filters = {
                category: null,
                priceRange: {
                    min: 0,
                    max: Infinity
                }
            };
        }
    }
}); 