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
        const response = await axios.get('/api/manufacturer/city');
        cities.value = response.data.cities;
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }
}

const point = ref({
    type: 0,
    city: 0,
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

    if (!errors.length) {
        axios.post('/api/manufacturer/point', point.value)
            .then(() => {
                toast.success(t('sentences.point_created'));
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

    if (point.value.type === 0) {
        errors.push({'point_type': t('errors.required_point_type')});
    }

    if (point.value.city === 0) {
        errors.push({'city': t('errors.required_city')});
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

onMounted(() => {
    fetchCities();
});

</script>

<template>
    <div class="bg-white rounded-2xl p-10 w-2/5 relative shadow-lg">
        <button class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-900" @click="closeModal">
            <i class="pi pi-times"></i>
        </button>
        <h2 class="text-2xl font-semibold text-left mb-6">{{
                $t('sentences.creating_point')
            }}</h2>
        <div class="flex justify-between mb-5">
            <div class="flex flex-col w-64">
                <label class="block" for="point_type">{{ $t('words.type') }}</label>
                <select id="point_type" v-model="point.type"
                        class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="0">{{ $t('sentences.not_selected') }}</option>
                    <option value="1">{{ $t('words.warehouse') }}</option>
                    <option value="2">{{ $t('sentences.pickup_point') }}</option>
                </select>
            </div>
            <div class="flex flex-col w-64">
                <label class="block" for="city">{{ $t('words.city') }}</label>
                <select id="city" v-model="point.city"
                        class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="0">{{ $t('sentences.not_selected') }}</option>
                    <option v-for="city in cities" :value="city.id">{{ city.city }}</option>
                </select>
            </div>
        </div>
        <button class="w-1/3 bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded-full" @click="create">
            {{ $t('words.save') }}
        </button>
    </div>
</template>

<style scoped>

</style>
