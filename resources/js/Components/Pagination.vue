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
            <Link
                v-if="links.prev"
                :href="links.prev"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
            >
                Previous
            </Link>

            <span
                v-else
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md"
            >
                Previous
            </span>

            <!-- Page Links -->
            <template v-if="links.links" v-for="(link, key) in links.links" :key="key">
                <Link
                    v-if="link.url && !isEndsLink(link)"
                    :href="link.url"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium border leading-5 rounded-md transition ease-in-out duration-150"
                    :class="{'bg-indigo-600 text-white border-indigo-600': link.active, 'text-gray-700 bg-white border-gray-300 hover:text-gray-500': !link.active}"
                >
                    {{ link.label }}
                </Link>
            </template>

            <!-- Next Page Link -->
            <Link
                v-if="links.next"
                :href="links.next"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
            >
                Next
            </Link>

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
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    meta: {
        type: Object,
        required: true,
        default: () => ({
            current_page: 1,
            from: 0,
            to: 0,
            total: 0,
            per_page: 10
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

const isEndsLink = (link) => {
    return link.label === '&laquo; Previous' || link.label === 'Next &raquo;';
};
</script>

<script>
export default {
    name: 'Pagination'
}
</script> 