import { createPinia } from 'pinia';
import { useCartStore } from './cartStore';

const pinia = createPinia();

export { pinia, useCartStore }; 