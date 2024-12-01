<script setup>
// import { Link } from '@inertiajs/vue3';

var props = defineProps({
    id: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div :id="id" class="hs-overlay hidden size-full fixed top-0 start-0 z-[60] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" :aria-labelledby="`${id}-label`">
        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">

                <div class="flex justify-between items-center py-3 px-4 border-b">
                    <h3 :id="`${id}-label`" class="font-bold text-gray-800">
                        <slot name="title" class="capitalize">Modal title</slot>
                    </h3>

                    <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" :data-hs-overlay="`#${id}`">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-4 overflow-y-auto">
                    <div class="p-5">
                        <div class="max-w-xl relative z-10 text-center mx-auto">
                            <slot name="content"></slot>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-1 py-3 px-4 border-t">
                    <button type="button" class="py-2 px-4 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" :data-hs-overlay="`#${id}`">Close</button>
                    <slot name="buttons"></slot>
                </div>

            </div>
        </div>
    </div>
</template>
