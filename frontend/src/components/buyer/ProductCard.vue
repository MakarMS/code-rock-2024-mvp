<script setup>
import {openModal} from "jenesius-vue-modal";
import BuyProduct from "@/components/buyer/modals/BuyProduct.vue";

const props = defineProps({
    product: {type: Object}
});

</script>

<template>
    <div class="flex m-10 shadow-lg p-5 rounded-xl justify-between w-8/12">
        <img :src="'http://api.localhost' + props.product.image" alt="" class="mb-5" width="300px">
        <div class="flex flex-col justify-between items-end">
            <p class="text-orange-500 mb-2">{{ $t('words.manufacturer') }}: {{ props.product.manufacturer }}</p>
            <div>
                <p class="text-xl text-orange-400 mb-2">{{ props.product.product_name }}</p>
                <p class="text-lg text-orange-500 mb-5 text-right">{{ props.product.cost }} ₽</p>
            </div>
            <button
                class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 transition-all mb-5 w-full"
                @click="openModal(BuyProduct, {id: props.product.id})">
                {{ $t('words.open') }}
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
