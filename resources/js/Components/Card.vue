<script setup>
import { Link } from '@inertiajs/vue3';

// var props = defineProps({
//     items: {
//         type: Object,
//         required: true,
//     },
// });

// var hasLink = (item) => (item.hasOwnProperty('link') && item.link !== '');
// var isLast = (idx) => (idx+1 == props.items.length);
</script>

<template>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
            <div>
                <slot name="header-title">
                    <h2 class="text-xl font-semibold text-gray-800">Header</h2>
                    <!-- <p class="text-sm text-gray-600">Create invoices, edit, download and more.</p> -->
                </slot>
            </div>

            <div>
                <div class="inline-flex gap-x-2">
                    <slot name="header-content" />
                </div>
            </div>
        </div>
        <!-- End Header -->

        <main>
            <slot name="content"></slot>
        </main>

        <footer class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
            <slot name="footer"></slot>
        </footer>
    </div>
</template>
