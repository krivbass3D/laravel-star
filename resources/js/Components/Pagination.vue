<template>
    <div v-if="meta && links" class="flex flex-col sm:flex-row items-center justify-between mt-4">
        <div v-if="meta.total" class="flex-1 text-sm text-gray-700 mb-4 sm:mb-0">
            Showing 
            <span class="font-medium">{{ meta.from || 0 }}</span>
            to
            <span class="font-medium">{{ meta.to || 0 }}</span>
            of
            <span class="font-medium">{{ meta.total || 0 }}</span>
            results
        </div>
        <div class="flex justify-center space-x-1">
            <!-- Previous Page Link -->
            <button
                v-if="hasPreviousPage"
                @click="changePage(meta.current_page - 1)"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
            >
                Previous
            </button>

            <span
                v-else
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md"
            >
                Previous
            </span>

            <template v-for="page in pageRange" :key="page">
                <button
                    @click="changePage(page)"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium border leading-5 rounded-md transition ease-in-out duration-150"
                    :class="{'bg-indigo-600 text-white border-indigo-600': page === meta.current_page, 'text-gray-700 bg-white border-gray-300 hover:text-gray-500': page !== meta.current_page}"
                >
                    {{ page }}
                </button>
            </template>

            <button
                v-if="hasNextPage"
                @click="changePage(meta.current_page + 1)"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
            >
                Next
            </button>

            <span
                v-else
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md"
            >
                Next
            </span>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    meta: {
        type: Object,
        required: true,
        default: () => ({
            current_page: 1,
            from: 0,
            to: 0,
            total: 0,
            per_page: 10,
            last_page: 1
        })
    },
    links: {
        type: Object,
        required: true,
        default: () => ({
            prev: null,
            next: null,
            links: []
        })
    }
});

const hasPreviousPage = computed(() => {
    return props.meta.current_page > 1;
});

const hasNextPage = computed(() => {
    return props.meta.current_page < props.meta.last_page;
});

const pageRange = computed(() => {
    const range = [];
    const totalPages = props.meta.last_page;
    const currentPage = props.meta.current_page;
    
    for (let i = 1; i <= totalPages; i++) {
        if (
            i === 1 || 
            i === totalPages ||
            (i >= currentPage - 2 && i <= currentPage + 2) 
        ) {
            range.push(i);
        }
    }
    return range;
});

const changePage = (page) => {
    const url = new URL(window.location.href);
    const params = Object.fromEntries(url.searchParams.entries());

    router.get(url.pathname, { 
        ...params,
        page: page 
    }, {
        preserveState: true,
        preserveScroll: true
    });
};
</script>

<script>
export default {
    name: 'Pagination'
}
</script> 