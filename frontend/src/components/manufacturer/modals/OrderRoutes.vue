<script setup>

import axios from "@/axios.js";
import {useToast} from "vue-toastification";
import {useI18n} from "vue-i18n";
import {onMounted, ref} from "vue";

const {t} = useI18n();
const toast = useToast();

const cities = ref([]);

const props = defineProps({
    id: {type: Number, default: 0}
});

const routes = ref([]);

async function fetchProduct() {
    if (props.id !== 0) {
        try {
            const response = await axios.get(`/api/manufacturer/order/${props.id}`);
            routes.value = response.data.routes;
        } catch (error) {
            toast.error(t('errors.unexpected_error'))
        }
    }
}

onMounted(() => {
    fetchProduct();
})
</script>

<template>
    <div class="bg-white rounded-2xl p-10 w-2/5 relative shadow-lg mix-h-5/12">
        <div class="ml-48 text-left">
            <p class="text-orange-500 mb-2">{{ $t('sentences.delivery_route') }}:</p>
            <span v-for="(route, index) in routes" :key="index" class="text-orange-500 ml-10 mb-2">
                {{ route.departure_point + ' -> ' + route.arrival_point }}<span
                v-if="index !== routes.length - 1">-></span><br>
            </span>
        </div>
    </div>
</template>

<style scoped>

</style>
