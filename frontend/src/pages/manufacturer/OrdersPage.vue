<script setup>
import Header from '../../components/manufacturer/Header.vue';
import {openModal} from 'jenesius-vue-modal';
import {onMounted, ref} from 'vue';
import {VueAwesomePaginate} from 'vue-awesome-paginate';
import axios from "@/axios.js";
import {useToast} from "vue-toastification";
import {useI18n} from "vue-i18n";
import OrderRoutes from "@/components/manufacturer/modals/OrderRoutes.vue";

const {t} = useI18n();
const toast = useToast();

const paginateHandler = (page) => {
    fetchPoints(page);
};

async function fetchPoints(page) {
    try {
        const response = await axios.get(`/api/manufacturer/order/?page=${page}`);
        orders.value = response.data.orders;
        currentPage.value = response.data.current_page;
        total.value = response.data.total
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }

}

const currentPage = ref(1);
const total = ref(0);

const orders = ref([]);

onMounted(() => {
    fetchPoints(currentPage.value);
})


const showModal = async (id) => {
    const modal = await openModal(OrderRoutes, {id: id});
}

</script>

<template>
    <Header/>
    <main class="text-orange-400 w-12/12 h-full shadow-lg m-10 rounded-lg p-5">
        <button
            class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 transition-all mb-5"
            @click="showModal(point.id)">
            {{ $t('words.create') }}
        </button>
        <hr>
        <div class="flex flex-col justify-center">
            <table class="w-full mt-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ $t('words.name') }}</th>
                    <th>{{ $t('words.quantity') }} ({{
                            $t('words.pcs')
                        }})
                    </th>
                    <th>{{ $t('words.cost') }} (₽)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="orders.length === 0">
                    <td class="text-center py-4" colspan="7">{{ $t('sentences.points_not_found') }}</td>
                </tr>
                <tr v-for="point in orders" v-else class="border-b-2">
                    <td class="text-center">{{ point.id }}</td>
                    <td class="text-center">{{ point.product_name }}</td>
                    <td class="text-center">{{ point.count }}</td>
                    <td class="text-center">{{ point.cost }}</td>
                    <td class="text-right w-60">
                        <button
                            class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 mr-5 mt-5 transition-all mb-5"
                            @click="showModal(point.id)">
                            {{ $t('words.routes') }}
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

