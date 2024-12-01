<script setup>
import { Head, Link } from '@inertiajs/vue3';
// import { inject, ref, computed } from 'vue';

import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Header from '../Header.vue';
import Footer from '../Footer.vue';
import NavBar from '@/Components/NavBar.vue';

// var route = inject('route');
var props = defineProps({
    movie: {
        type: Object,
        required: true,
    },
    movieGenres: {
        type: Array,
        required: true,
    },
    genres: {
        type: Array,
        required: true,
    },
});

// onMounted(async () => {
//     console.log('loaded');
// });
</script>

<template>

    <Head title="Movie" />
    <!-- <pre>{{ JSON.stringify(movie, null, 4) }}</pre> -->
    <!-- <pre>{{ JSON.stringify(movieGenres, null, 4) }}</pre> -->
    <!-- <pre>{{ JSON.stringify(genres, null, 4) }}</pre> -->

    <div class="flex flex-col flex-nowrap justify-between items-center gap-4 h-full px-4 sm:px-6 lg:px-8">
        <Header>
            <template #navbar>
                <NavBar :items="[
                    { label: 'Home', link: '/' },
                    { label: 'Genres', link: route('genres.index') },
                    { label: 'Movies', link: route('movies.index'), active: true },
                ]" />
            </template>

            <template #breadcrumbs>
                <Breadcrumbs :items="[
                    { label: 'Home', link: '/' },
                    { label: 'Movies', link: route('movies.index') },
                    { label: movie.name, link: '' },
                ]" />
            </template>
        </Header>

        <main class="flex-grow w-full">
            <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-7 lg:gap-x-8 xl:gap-x-12 lg:items-center">
                    <div class="lg:col-span-3">
                        <img :src="`/storage/${movie.link}`" :alt="movie.name" width="320" class="rounded-xl">
                    </div>

                    <div class="lg:col-span-4 mt-10 lg:mt-0">
                    <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl md:text-5xl lg:text-6xl">{{ movie.name }}</h1>
                    <p class="mt-3 text-lg text-gray-800">ID: {{ movie.id }}</p>
                    <p class="mt-3 text-lg text-gray-800">Status: {{ movie.status }}</p>

                    <div class="inline-flex flex-wrap gap-x-1 gap-y-1 mt-5">
                        <!-- <button v-for="genre of genres" :key="genre.id" type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">{{ genre.name }}</button> -->
                        <button v-for="genre of genres" :key="genre.id" type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">{{ genre.name }}</button>
                    </div>

                    </div>
                </div>
            </div>

        </main>

        <Footer />
    </div>

</template>
