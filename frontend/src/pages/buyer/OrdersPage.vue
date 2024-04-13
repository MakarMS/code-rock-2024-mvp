<script setup>
import Header from '../../components/buyer/Header.vue';
import {onMounted, ref} from "vue";
import axios from "@/axios.js";
import {VueAwesomePaginate} from "vue-awesome-paginate";

import {useToast} from "vue-toastification";
import {useI18n} from "vue-i18n";
import OrderCard from "@/components/buyer/OrderCard.vue";

const {t} = useI18n();
const toast = useToast();

async function fetchOrders(page) {
    try {
        const response = await axios.get(`/api/buyer/order/?page=${page}`);
        orders.value = response.data.orders;
        currentPage.value = response.data.current_page;
        total.value = response.data.total
    } catch (error) {
        toast.error(t('errors.unexpected_error'));
    }
}

const paginateHandler = (page) => {
    fetchOrders(page);
};

const orders = ref([]);
const currentPage = ref(1);
const total = ref(0);

onMounted(() => {
    fetchOrders(currentPage.value);
})
</script>

<template>
    <Header/>
    <main class="text-orange-400 w-12/12 h-full shadow-lg m-10 rounded-lg p-5">
        <div class="flex flex-col items-center">
            <OrderCard v-for="order in orders" :order="order" :page="currentPage" :reloadOrders="fetchOrders"/>
            <vue-awesome-paginate v-model="currentPage" :items-per-page="10" :max-pages-shown="5"
                                  :on-click="paginateHandler" :total-items="total" class="mt-10 flex justify-center"/>
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


