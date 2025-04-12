import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    state: () => {
        try {
            const savedCart = localStorage.getItem('cart');
            const items = savedCart ? JSON.parse(savedCart) : [];
            console.log('Initialized cart items:', items);
            return { items };
        } catch (error) {
            console.error('Error initializing cart:', error);
            return { items: [] };
        }
    },
    
    getters: {
        totalItems: (state) => state.items.length,
        totalAmount: (state) => state.items.reduce((sum, item) => sum + (item.price * item.quantity), 0),
        cartItems: (state) => state.items,
        totalPrice() {
            const total = this.items.reduce((sum, item) => {
                return sum + (parseFloat(item.price) * item.quantity);
            }, 0);
            console.log('Calculated total price:', total);
            return total;
        }
    },
    
    actions: {
        addToCart(product) {
            try {
                const existingItem = this.items.find(item => item.id === product.id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    this.items.push({
                        id: product.id,
                        name: product.name,
                        price: parseFloat(product.price),
                        image: product.image,
                        quantity: 1
                    });
                }
                
                console.log('Updated cart items:', this.items);
                localStorage.setItem('cart', JSON.stringify(this.items));
            } catch (error) {
                console.error('Error adding to cart:', error);
            }
        },
        
        removeFromCart(productId) {
            try {
                this.items = this.items.filter(item => item.id !== productId);
                console.log('Updated cart items after removal:', this.items);
                localStorage.setItem('cart', JSON.stringify(this.items));
            } catch (error) {
                console.error('Error removing from cart:', error);
            }
        },
        
        updateQuantity(productId, quantity) {
            try {
                const item = this.items.find(item => item.id === productId);
                if (item) {
                    item.quantity = Math.max(1, quantity);
                    console.log('Updated cart items after quantity change:', this.items);
                    localStorage.setItem('cart', JSON.stringify(this.items));
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
            }
        },
        
        clearCart() {
            try {
                this.items = [];
                localStorage.removeItem('cart');
            } catch (error) {
                console.error('Error clearing cart:', error);
            }
        }
    }
}); 