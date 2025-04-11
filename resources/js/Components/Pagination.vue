<template>
    <div class="flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            <Link v-if="links.prev" :href="links.prev" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Назад
            </Link>
            <Link v-if="links.next" :href="links.next" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Вперед
            </Link>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Показано с
                    <span class="font-medium">{{ links.from }}</span>
                    по
                    <span class="font-medium">{{ links.to }}</span>
                    из
                    <span class="font-medium">{{ links.total }}</span>
                    результатов
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <Link v-for="(link, key) in links.links" :key="key"
                        :href="link.url"
                        v-html="link.label"
                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                        :class="{
                            'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                            'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active && link.url,
                            'bg-white border-gray-300 text-gray-300 cursor-not-allowed': !link.url
                        }"
                    />
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Object
});
</script>

<script>
export default {
    name: 'Pagination'
}
</script> 