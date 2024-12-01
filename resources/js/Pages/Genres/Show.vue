<script setup>
import { Head, Link } from '@inertiajs/vue3';
// import { inject, ref, computed } from 'vue';

import Pagination from '@/Pagination.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Header from '../Header.vue';
import Footer from '../Footer.vue';
import NavBar from '@/Components/NavBar.vue';
import Card from '@/Components/Card.vue';
import Table from '@/Components/Table.vue';

// var route = inject('route');
var props = defineProps({
    genre: {
        type: Object,
        required: true,
    },
    movies: {
        type: Array,
        required: true,
    },
});

// onMounted(async () => {
//     console.log('loaded');
// });
</script>

<template>

    <Head title="Genre" />
    <!-- <pre>{{ JSON.stringify(genre, null, 4) }}</pre> -->
    <!-- <pre>{{ JSON.stringify(movies, null, 4) }}</pre> -->

    <div class="flex flex-col flex-nowrap justify-between items-center gap-4 h-full px-4 sm:px-6 lg:px-8">
        <Header>
            <template #navbar>
                <NavBar :items="[
                    { label: 'Home', link: '/' },
                    { label: 'Genres', link: route('genres.index'), active: true },
                    { label: 'Movies', link: route('movies.index') },
                ]" />
            </template>

            <template #breadcrumbs>
                <Breadcrumbs :items="[
                    { label: 'Home', link: '/' },
                    { label: 'Genres', link: route('genres.index') },
                    { label: genre.name, link: '' },
                ]" />
            </template>
        </Header>

        <main class="flex-grow w-full">
            <Card>
                <template #header-title>
                    <h2 class="text-xl font-semibold text-gray-800">Genre: {{ genre.name }}</h2>
                    <p class="text-sm text-gray-600 mt-1">ID: {{ genre.id }}</p>
                </template>

                <template #header-content>
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                        onclick="history.back()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        Back</button>

                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        New
                    </button>
                </template>

                <template #content>
                    <Table :total="movies.length" :heading="['ID', 'Movie', 'Action']">
                        <template #rows>
                            <tr v-for="movie, n of movies" :key="movie.id" :id="`row-movie-${movie.id}`" class="bg-white hover:bg-gray-50 text-sm">
                                <td class="size-px whitespace-nowrap">
                                    <span class="block px-6 py-2 font-mono text-blue-600">{{ movie.id }}</span>
                                </td>

                                <td class="size-px whitespace-nowrap">
                                    <Link :href="route('movies.show', movie.id)"
                                        class="block px-6 py-2 text-blue-600">{{ movie.name }}</Link>
                                </td>

                                <td class="size-px whitespace-nowrap text-right">
                                    <div class="block px-6 text-slate-600">
                                        <button type="button"
                                            class="inline-flex items-center gap-x-1 mr-2 text-slate-500 hover:text-black focus:relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Edit
                                        </button>

                                        <!--
                                        TODO: add csrf
                                        @csrf
                                        @method('DELETE')
                                        -->

                                        <button type="button"
                                            class="inline-flex items-center gap-x-1 ml-2 text-slate-500 hover:text-black focus:relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </Table>
                </template>

                <!-- <template #footer></template> -->
            </Card>
        </main>

        <Footer />
    </div>

</template>
