<script setup>
import { Link } from '@inertiajs/vue3';

var props = defineProps({
    items: {
        type: Array,
        required: true,
    },
});

var hasLink = (item) => (item.hasOwnProperty('link') && item.link !== '');
var isLast = (idx) => (idx+1 == props.items.length);
</script>

<template>
    <ol class="flex items-center whitespace-nowrap mt-5 text-sm">
        <template v-for="item, idx of props.items" :key="item.label">

            <template v-if="!isLast(idx)">
                <li class="inline-flex items-center text-gray-500">
                    <Link v-if="hasLink(item)" :href="item.link" class="hover:text-blue-600 focus:outline-none focus:text-blue-600">{{ item.label }}</Link>
                    <a v-else>{{ item.label }}</a>
                </li>
                <li class="inline-flex items-center mx-2">
                    <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </li>
            </template>

            <template v-else>
                <li class="inline-flex items-center">
                    <span class="flex items-center text-gray-500">{{ item.label }}</span>
                </li>
            </template>

        </template>
    </ol>
</template>
