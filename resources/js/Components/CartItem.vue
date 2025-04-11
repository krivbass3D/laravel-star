<template>
    <div class="flex items-center justify-between p-4 border-b">
        <div class="flex items-center space-x-4">
            <img :src="item.image" :alt="item.name" class="w-20 h-20 object-cover rounded">
            <div>
                <h3 class="text-lg font-semibold">{{ item.name }}</h3>
                <p class="text-gray-600">€{{ item.price }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center border rounded">
                <button @click="decreaseQuantity" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                <span class="px-3 py-1">{{ item.quantity }}</span>
                <button @click="increaseQuantity" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
            </div>
            <button @click="removeItem" class="text-purple-600 hover:text-purple-800">Remove</button>
        </div>
    </div>
</template>

<script setup>
import { useCartStore } from '@/stores/cartStore';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const cart = useCartStore();

const increaseQuantity = () => {
    cart.updateQuantity(props.item.id, props.item.quantity + 1);
};

const decreaseQuantity = () => {
    if (props.item.quantity > 1) {
        cart.updateQuantity(props.item.id, props.item.quantity - 1);
    }
};

const removeItem = () => {
    cart.removeFromCart(props.item.id);
};
</script> 