import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: []
    }),
    
    getters: {
        totalItems: (state) => state.items.length,
        totalAmount: (state) => state.items.reduce((sum, item) => sum + (item.price * item.quantity), 0),
        cartItems: (state) => state.items
    },
    
    actions: {
        addToCart(product) {
            const existingItem = this.items.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.items.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1
                });
            }
        },
        
        removeFromCart(productId) {
            this.items = this.items.filter(item => item.id !== productId);
        },
        
        updateQuantity(productId, quantity) {
            const item = this.items.find(item => item.id === productId);
            if (item) {
                item.quantity = Math.max(1, quantity);
            }
        },
        
        clearCart() {
            this.items = [];
        }
    }
}); 