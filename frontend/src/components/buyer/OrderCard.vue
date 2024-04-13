<script setup>
import axios from "@/axios.js";
import {useI18n} from "vue-i18n";
import {useToast} from "vue-toastification";

const {t} = useI18n();
const toast = useToast();

const props = defineProps({
    order: {type: Object},
    page: {type: Number},
    reloadOrders: Function
});

const reOrder = (id) => {
    axios.post(`/api/buyer/order/reorder/${id}`)
        .then(() => {
            handleReorder()
            toast.success(t('sentences.product_reordered'));
        })
        .catch(error => {
            console.error(error)
            toast.error(t('errors.unexpected_error'));
        });
}

const handleReorder = () => {
    props.reloadOrders(props.page);
}

</script>

<template>
    <div class="flex m-10 shadow-lg p-5 rounded-xl w-8/12">
        <img :src="'http://api.localhost' + props.order.image" alt="" class="mb-5" width="300px">
        <div class="ml-5">
            <p class="text-orange-500 mb-2">{{ $t('words.name') }}: {{ props.order.product_name }}</p>
            <p class="text-orange-500 mb-2">{{ $t('words.manufacturer') }}: {{ props.order.manufacturer }}</p>
            <p class="text-orange-500 mb-2">{{ $t('words.quantity') }}: {{ props.order.count }} ({{
                    $t('words.pcs')
                }})</p>
            <p class="text-orange-500 mb-2">{{ $t('words.cost') }}: {{ props.order.cost }} (₽)</p>
        </div>
        <div class="ml-48">
            <p class="text-orange-500 mb-2">{{ $t('sentences.delivery_route') }}:</p>
            <span v-for="(route, index) in props.order.routes" :key="index" class="text-orange-500 ml-10 mb-2">
                {{ route.departure_point + ' -> ' + route.arrival_point }}<span
                v-if="index !== props.order.routes.length - 1">-></span><br>
            </span>
        </div>
        <div class="flex flex-col justify-end">
            <button
                class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 transition-all mb-5 w-32"
                @click="reOrder(props.order.id)">
                {{ $t('sentences.reorder') }}
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
