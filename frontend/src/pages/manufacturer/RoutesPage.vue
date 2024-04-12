<script setup>
import Header from '../../components/manufacturer/Header.vue';
import {openModal} from 'jenesius-vue-modal';
import CreateEditRoute from '@/components/manufacturer/modals/CreateEditRoute.vue';
import {onMounted, ref} from 'vue';
import {VueAwesomePaginate} from 'vue-awesome-paginate';
import axios from "@/axios.js";
import {useToast} from "vue-toastification";
import {useI18n} from "vue-i18n";

const {t} = useI18n();
const toast = useToast();

const paginateHandler = (page) => {
    fetchRoutes(page);
};

async function fetchRoutes(page) {
    try {
        const response = await axios.get(`/api/manufacturer/route?page=${page}`);
        routes.value = response.data.data;
        currentPage.value = response.data.meta.current_page;
        total.value = response.data.meta.total
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }

}

const currentPage = ref(1);
const total = ref(0);

const routes = ref([]);

onMounted(() => {
    fetchRoutes(currentPage.value);
})


const showModal = async (props = {}) => {
    const modal = await openModal(CreateEditRoute, props);

    modal.onclose = () => {
        fetchRoutes(currentPage.value);
    };
}

const deleteRoute = async (id) => {
    try {
        await axios.delete(`/api/manufacturer/route/${id}`);
        toast.success(t('sentences.route_deleted'));
        await fetchRoutes(currentPage.value);
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }
}


</script>

<template>
    <Header/>
    <main class="text-orange-400 w-12/12 h-full shadow-lg m-10 rounded-lg p-5">
        <button
            class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 transition-all mb-5"
            @click="showModal">
            {{ $t('words.create') }}
        </button>
        <hr>
        <div class="flex flex-col justify-center">
            <table class="w-full mt-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ $t('sentences.departure_point') }}</th>
                    <th>{{ $t('sentences.arrival_point') }}</th>
                    <th>{{ $t('words.cost') }} (₽)</th>
                    <th>{{ $t('sentences.length_delivery') }} ({{ $t('words.short_hours') }})</th>
                    <th>{{ $t('words.distance') }} ({{ $t('words.short_km') }})</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="routes.length === 0">
                    <td class="text-center py-4" colspan="7">{{ $t('sentences.routes_not_found') }}</td>
                </tr>
                <tr v-for="route in routes" v-else class="border-b-2">
                    <td class="text-center">{{ route.id }}</td>
                    <td class="text-center">{{ route.departure_point }}</td>
                    <td class="text-center">{{ route.arrival_point }}</td>
                    <td class="text-center">{{ route.cost }}</td>
                    <td class="text-center">{{ route.length_delivery }}</td>
                    <td class="text-center">{{ route.distance }}</td>
                    <td class="text-right w-60">
                        <button
                            class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 mr-5 mt-6 transition-all mb-5"
                            @click="showModal({id: route.id})">
                            {{ $t('words.edit') }}
                        </button>
                        <button
                            class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 transition-all mb-5"
                            @click="deleteRoute(route.id)">
                            {{ $t('words.delete') }}
                        </button>
                    </td>
                </tr>
                </tbody>

            </table>
            <vue-awesome-paginate v-model="currentPage"
                                  :items-per-page="10"
                                  :max-pages-shown="5"
                                  :on-click="paginateHandler"
                                  :total-items="total"
                                  class="mt-10 flex justify-center"
            />
        </div>
    </main>
</template>

<style>
.pagination-container {
    display: flex;
    column-gap: 10px;
}

.paginate-buttons {
    height: 40px;
    width: 40px;
    border-radius: 20px;
    cursor: pointer;
    background-color: rgb(242, 242, 242);
    border: 1px solid rgb(217, 217, 217);
    color: black;
}

.paginate-buttons:hover {
    background-color: #d8d8d8;
}

.active-page {
    background-color: rgb(251, 146, 60);
    border: 1px solid rgb(251, 146, 60);
    color: white;
}

.active-page:hover {
    background-color: rgb(251, 146, 60);
}
</style>

