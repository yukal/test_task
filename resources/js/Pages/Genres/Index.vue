<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { inject, ref, onMounted } from 'vue';
import axios from 'axios';

import Pagination from '@/Pagination.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Header from '../Header.vue';
import Footer from '../Footer.vue';
import NavBar from '@/Components/NavBar.vue';
import Card from '@/Components/Card.vue';
import Table from '@/Components/Table.vue';
import Dialog from '@/Components/Dialog.vue';

var route = inject('route');
var props = defineProps({
    genres: {
        type: Object,
        required: true,
    },
    i: {
        type: Number,
        required: true,
    },
});

var genreName = ref('');
var genreToUpdate = ref({
    id: 0,
    name: '',
});

async function destroyGenre(genreID) {
    var response;

    // console.log(props.genres);
    // console.log(route('api.v1.genres.destroy', genreID));
    //

    try {
        response = await axios.delete(route('api.v1.genres.destroy', genreID));
        // response = await axios.delete('/api/v1/genres/'+ genreID);

        if (response.status > 199 && response.status < 300) {
            router.reload({ only: ['genres'] });
        }

    } catch(err) {
        console.error(err);
    }
}

async function createGenre(name) {
    var response;

    try {
        response = await axios.post(route('api.v1.genres.store'), { name });

        if (response.status > 199 && response.status < 300) {
            router.reload({ only: ['genres'] });
        }

    } catch(err) {
        console.error(err);
    }

    HSOverlay.close('#modal-create-genre');
}

async function updateGenre(genre, name) {
    var response;

    try {
        response = await axios.put(route('api.v1.genres.update', genre.id), { name });

        if (response.status == 200) {
            router.reload({ only: ['genres'] });
        }

    } catch(err) {
        console.error(err);
    }

    HSOverlay.close('#modal-update-genre');
}

function onShowModalCreateGenre() {
    genreName.value = '';
    HSOverlay.open('#modal-create-genre');
}

function onShowModalUpdateGenre(genre) {
    genreName.value = genre.name;
    genreToUpdate.value = genre;

    HSOverlay.open('#modal-update-genre');
}

onMounted(async () => {
    // console.log('page::onMounted');
    window.HSStaticMethods.autoInit();
});
</script>

<template>

    <Head title="Genres" />

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
                    { label: 'Genres', link: '' },
                ]" />
            </template>
        </Header>

        <main class="flex-grow w-full">
            <Card>
                <template #header-title>
                    <h2 class="text-xl font-semibold text-gray-800">Genres</h2>
                    <p class="text-sm text-gray-600 mt-1">Create new genres, edit, or remove.</p>
                </template>

                <template #header-content>
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                        onclick="history.back()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        Back</button>

                    <button type="button" @click="onShowModalCreateGenre()"
                        class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        New
                    </button>
                </template>

                <template #content>
                    <Table :total="genres.total" :heading="['No', 'ID', 'Genre', 'Action']">
                        <template #rows>
                            <tr v-for="genre, n of genres.data" :key="genres.data.id" class="bg-white hover:bg-gray-50 text-sm">
                                <td class="size-px whitespace-nowrap">
                                    <span class="block px-6 py-2 font-mono text-slate-600">{{ i+n+1 }}</span>
                                </td>

                                <td class="size-px whitespace-nowrap">
                                    <span class="block px-6 py-2 font-mono text-blue-600">{{ genre.id }}</span>
                                </td>

                                <td class="size-px whitespace-nowrap">
                                    <Link :href="route('genres.show', genre.id)"
                                        class="block px-6 py-2 text-blue-600">{{ genre.name }}</Link>
                                </td>

                                <td class="size-px whitespace-nowrap text-right">
                                    <div class="block px-6 text-slate-600">
                                        <button type="button" @click="onShowModalUpdateGenre(genre)"
                                            class="inline-flex items-center gap-x-1 mr-2 text-slate-500 hover:text-black focus:relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Edit
                                        </button>

                                        <!-- TODO: add csrf -->
                                        <!-- @csrf -->
                                        <!-- @method('DELETE') -->

                                        <button type="button" @click="destroyGenre(genre.id)"
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

                <template #footer>
                    <div>
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold text-gray-800">{{ genres.total }}</span> results
                        </p>
                    </div>

                    <div>
                        <div class="inline-flex gap-x-2">
                            <Pagination :pagination="genres" />
                        </div>
                    </div>
                </template>
            </Card>
        </main>

        <Footer />
    </div>

    <Dialog id="modal-create-genre">
        <template #title>Create Genre Name</template>

        <template #content>
            <div class="space-y-3">
                <!-- Floating Input -->
                <div class="relative">
                    <input type="text" id="input-genre-name" v-model="genreName"
                        class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                        focus:pt-6
                        focus:pb-2
                        [&:not(:placeholder-shown)]:pt-6
                        [&:not(:placeholder-shown)]:pb-2
                        autofill:pt-6
                        autofill:pb-2" placeholder="Scary Genre">

                    <label for="input-genre-name" class="absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] peer-disabled:opacity-50 peer-disabled:pointer-events-none
                        peer-focus:scale-90
                        peer-focus:translate-x-0.5
                        peer-focus:-translate-y-1.5
                        peer-focus:text-gray-500
                        peer-[:not(:placeholder-shown)]:scale-90
                        peer-[:not(:placeholder-shown)]:translate-x-0.5
                        peer-[:not(:placeholder-shown)]:-translate-y-1.5
                        peer-[:not(:placeholder-shown)]:text-gray-500">genre name</label>
                </div>
                <!-- End Floating Input -->
            </div>
        </template>

        <template #buttons>
            <button type="button"
                class="py-2 px-5 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                @click="createGenre(genreName)">Add</button>
        </template>
    </Dialog>

    <Dialog id="modal-update-genre">
        <template #title>Update Genre Name</template>

        <template #content>
            <div class="space-y-3">
                <!-- Floating Input -->
                <div class="relative">
                    <input type="text" id="input-genre-name" v-model="genreName"
                        class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                        focus:pt-6
                        focus:pb-2
                        [&:not(:placeholder-shown)]:pt-6
                        [&:not(:placeholder-shown)]:pb-2
                        autofill:pt-6
                        autofill:pb-2" placeholder="Scary Genre">

                    <label for="input-genre-name" class="absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] peer-disabled:opacity-50 peer-disabled:pointer-events-none
                        peer-focus:scale-90
                        peer-focus:translate-x-0.5
                        peer-focus:-translate-y-1.5
                        peer-focus:text-gray-500
                        peer-[:not(:placeholder-shown)]:scale-90
                        peer-[:not(:placeholder-shown)]:translate-x-0.5
                        peer-[:not(:placeholder-shown)]:-translate-y-1.5
                        peer-[:not(:placeholder-shown)]:text-gray-500">genre name</label>
                </div>
                <!-- End Floating Input -->
            </div>
        </template>

        <template #buttons>
            <button type="button"
                class="py-2 px-4 inline-flex items-center gap-x-1 text-sm font-medium rounded-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                @click="updateGenre(genreToUpdate, genreName)">Update</button>
        </template>
    </Dialog>
</template>
