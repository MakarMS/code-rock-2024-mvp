<script setup>
import {onMounted, ref} from "vue";
import axios from "@/axios.js";
import {useI18n} from "vue-i18n";
import {useToast} from "vue-toastification";
import {closeModal} from "jenesius-vue-modal";

const {t} = useI18n();
const toast = useToast();

const props = defineProps({
    id: {type: Number}
});

const product = ref([]);

async function fetchProduct() {
    try {
        const response = await axios.get(`/api/buyer/product/${props.id}`);
        product.value = response.data;
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }
}

onMounted(() => {
    fetchProduct();
});
</script>

<template>
    <div class="bg-white rounded-2xl p-10 w-2/5 relative shadow-lg mix-h-5/12">
        <button class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-900" @click="closeModal">
            <i class="pi pi-times"></i>
        </button>
        <h2 class="text-2xl font-semibold text-left mb-6">{{
                $t('sentences.product_info')
            }}</h2>
        <div class="flex justify-between mb-5">
            <div class="flex flex-col justify-between">
                <img :src="'http://api.localhost/storage/' + product.image" alt="" width="300px"/>
            </div>
            <div class="flex flex-col">
                <div class="flex flex-col w-64">
                    <label class="block" for="product_name">{{ $t('sentences.product_name') }}</label>
                    <input id="product_name" :value="product.product_name" class="text-center px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                           disabled
                           list="cost" type="text">
                </div>
                <div class="flex flex-col w-64 mt-5">
                    <label class="block" for="cost">{{ $t('words.cost') }} (₽) </label>
                    <input id="cost" :value="product.cost" class="text-center px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                           disabled
                           type="text">
                </div>
                <div class="flex">
                    <div class="flex flex-col w-20 mt-5">
                        <label class="block text-center" for="height">{{ $t('words.height') }} ({{
                                $t('words.m')
                            }}) </label>
                        <input id="height" :value="product.height" class="text-center mr-1 ml-1 px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                               disabled
                               type="text">
                    </div>
                    <div class="flex flex-col w-20 mt-5">
                        <label class="block text-center" for="width">{{ $t('words.width') }} ({{
                                $t('words.m')
                            }}) </label>
                        <input id="width" :value="product.width" class="text-center mr-1 ml-1 px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                               disabled
                               type="text">
                    </div>
                    <div class="flex flex-col w-20 mt-5">
                        <label class="block text-center" for="depth">{{ $t('words.depth') }} ({{
                                $t('words.m')
                            }}) </label>
                        <input id="depth" :value="product.depth" class="text-center mr-1 ml-1 px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                               disabled
                               type="text">
                    </div>
                </div>
                <div class="flex flex-col w-64 mt-5">
                    <label class="block" for="cost">{{ $t('words.mass') }} ({{ $t('words.short_kg') }}) </label>
                    <input id="cost" :value="product.mass" class="text-center px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                           disabled
                           type="text">
                </div>
            </div>
        </div>
        <div class="flex flex-col mb-5 h-32">
            <label class="block" for="description">{{ $t('words.description') }}</label>
            <textarea id="description" :value="product.description" class="w-full h-32 resize-none border border-gray-300 p-2 rounded-md"
                      disabled></textarea>
        </div>
        <button class="w-1/3 bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded-full" @click="create">
            {{ $t('words.save') }}
        </button>
    </div>
</template>

<style scoped>

</style>
