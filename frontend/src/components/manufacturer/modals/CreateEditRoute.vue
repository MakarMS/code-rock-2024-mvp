<script setup>

import {closeModal} from "jenesius-vue-modal";
import axios from "@/axios.js";
import {useToast} from "vue-toastification";
import {useI18n} from "vue-i18n";
import {onMounted, ref} from "vue";

const {t} = useI18n();
const toast = useToast();

const cities = ref([]);

async function fetchCities() {
    try {
        const response = await axios.get('/api/city');
        cities.value = response.data.cities;
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }

}

const route = ref({
    departure_point: 0,
    arrival_point: 0,
    cost: 0,
    length_delivery: 0,
    distance: 0
});

const create = () => {
    const errors = validate();

    for (const error of errors) {
        const key = Object.keys(error)[0];
        const errorMessage = error[key];

        const element = document.getElementById(key);

        if (element) {
            addErrorClasses(element);
            addErrorFocusListener(element);
        }

        toast.error(errorMessage);
    }

    if (errors) {
        axios.post(`/api/manufacturer/route`, route.value)
            .then(() => {
                toast.success(t('sentences.route_created'))
                closeModal();
            })
            .catch(error => {
                console.error(error)
                toast.error(t('errors.unexpected_error'));
            });
    }
}

const validate = () => {
    let errors = [];

    if (route.value.departure_point === 0) {
        errors.push({'departure_point': t('errors.required_departure_point')});
    }

    if (route.value.arrival_point === 0) {
        errors.push({'arrival_point': t('errors.required_arrival_point')});
    }

    const costValue = Number(route.value.cost);
    if (isNaN(costValue) || costValue < 0) {
        errors.push({'cost': t('errors.wrong_cost')});
    }

    const lengthDeliveryValue = Number(route.value.length_delivery);
    if (isNaN(lengthDeliveryValue) || lengthDeliveryValue < 0) {
        errors.push({'length_delivery': t('errors.wrong_length_delivery')});
    }

    const distanceValue = Number(route.value.distance);
    if (isNaN(distanceValue) || distanceValue < 0) {
        errors.push({'distance': t('errors.wrong_distance')});
    }

    return errors;
}

const addErrorClasses = (element) => {
    element.classList.remove('border-gray-300');
    element.classList.remove('focus:ring-orange-400');
    element.classList.add('border-red-600');
    element.classList.add('focus:ring-red-600');
}

const addErrorFocusListener = (element) => {
    element.addEventListener('focusout', () => {
        element.classList.remove('border-red-600');
        element.classList.remove('focus:ring-red-600');
        element.classList.add('border-gray-300');
        element.classList.add('focus:ring-orange-400');
    });
}

onMounted(fetchCities)
</script>

<template>
    <div class="bg-white rounded-2xl p-10 w-2/5 relative shadow-lg">
        <button class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-900" @click="closeModal">
            <i class="pi pi-times"></i>
        </button>
        <h2 class="text-2xl font-semibold text-left mb-6">{{ $t('routes.creating_route') }}</h2>
        <div class="flex justify-between mb-5">
            <div class="flex flex-col w-64">
                <label class="block" for="departure_point">{{ $t('sentences.departure_point') }}</label>
                <select id="departure_point" v-model="route.departure_point"
                        class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="0">{{ $t('sentences.not_selected') }}</option>
                    <option v-for="city in cities" :value="city.id">{{ city.city }}</option>
                </select>
            </div>
            <div class="flex flex-col w-64">
                <label class="block" for="arrival_point">{{ $t('sentences.departure_point') }}</label>
                <select id="arrival_point" v-model="route.arrival_point"
                        class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="0">{{ $t('sentences.not_selected') }}</option>
                    <option v-for="city in cities" :value="city.id">{{ city.city }}</option>
                </select>
            </div>
        </div>
        <div class="flex justify-between mb-5">
            <div class="flex flex-col w-64">
                <label class="block" for="cost">{{ $t('words.cost') }} ({{ $t('sentences.in_rubles') }})</label>
                <input v-model="route.cost"
                       class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       list="cost"
                       type="text">
            </div>
            <div class="flex flex-col w-64">
                <label class="block" for="length_delivery">{{ $t('sentences.length_delivery') }}
                    ({{ $t('sentences.in_hours') }}) </label>
                <input v-model="route.length_delivery"
                       class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       list="length_delivery"
                       type="text">
            </div>
        </div>
        <div class="flex justify-between mb-5">
            <div class="flex flex-col w-64">
                <label class="block" for="distance">{{ $t('words.distance') }} ({{ $t('sentences.in_km') }})</label>
                <input v-model="route.distance"
                       class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       list="distance"
                       type="text">
            </div>
        </div>
        <button class="w-1/3 bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded-full" @click="create">
            {{ $t('words.save') }}
        </button>
    </div>
</template>

<style scoped>

</style>
