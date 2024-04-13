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

const count = ref(0);

async function fetchProduct() {
    try {
        const response = await axios.get(`/api/buyer/product/${props.id}`);
        product.value = response.data;
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }
}

const deliveryRoutesCheap = ref([]);
const deliveryRoutesFast = ref([]);

let cheapSelectedValue = ref(0);
let fastSelectedValue = ref(0);

let cheapDisabled = ref(false);
let fastDisabled = ref(false);

async function fetchPlan(plan) {
    try {
        const response = await axios.get(`/api/buyer/delivery/plan/${plan}/?product_id=${props.id}`);
        return response.data.data;
    } catch (error) {
        toast.error(t('errors.unexpected_error'))
    }
}

const changeDeliveryPlan = (type) => {
    if (type === 'cheap') {
        if (cheapSelectedValue.value !== 0) {
            fastSelectedValue.value = 0;
            fastDisabled.value = false;
        } else {
            fastDisabled.value = true;
        }
    } else if (type === 'fast') {
        if (fastSelectedValue.value !== 0) {
            cheapSelectedValue.value = 0;
            cheapDisabled.value = false;
        } else {
            cheapDisabled.value = true;
        }
    }
}

const buyProduct = () => {
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
        const data = {
            product_id: props.id,
            count: count.value,
            routes: cheapSelectedValue.value !== 0 ? cheapSelectedValue.value : fastSelectedValue.value
        };

        axios.post('/api/buyer/order', data)
            .then(() => {
                toast.success(t('sentences.product_ordered'));
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

    const countValidate = Number(count.value);
    if (isNaN(countValidate) || countValidate <= 0) {
        errors.push({'count': t('errors.required_count')});
    }

    if (cheapSelectedValue.value === 0 && fastSelectedValue.value === 0) {
        errors.push({'cheap_select': t('errors.required_delivery_route')});
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

onMounted(async () => {
    await fetchProduct();
    deliveryRoutesCheap.value = await fetchPlan(1);
    deliveryRoutesFast.value = await fetchPlan(2);
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
                <input id="count" v-model="count" class="text-center px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       min="0"
                       type="number">
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
        <div class="flex flex-col mb-5">
            <p class="text-xl font-semibold text-left mb-6">{{ $t('sentences.delivery_plan') }}</p>
            <p>{{ $t('sentences.delivery_plan_cheap') }}</p>
            <select id="cheap_select" v-model="cheapSelectedValue"
                    :disabled="cheapDisabled"
                    class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400" @change="() => changeDeliveryPlan('cheap')">
                <option selected value="0">{{ $t('sentences.not_selected') }}</option>
                <option v-for="route in deliveryRoutesCheap" :value="route.routes_ids.join('-')">
                    {{ route.total_cost + '₽ — ' + route.total_length_delivery + ' ' + $t('words.short_hours') }}
                </option>
            </select>

            <p class="mt-5">{{ $t('sentences.delivery_plan_fast') }}</p>
            <select id="fast_select" v-model="fastSelectedValue"
                    :disabled="fastDisabled"
                    class="px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400" @change="() => changeDeliveryPlan('fast')">
                <option selected value="0">{{ $t('sentences.not_selected') }}</option>
                <option v-for="route in deliveryRoutesFast" :value="route.routes_ids.join('-')">
                    {{ route.total_cost + '₽ — ' + route.total_length_delivery + ' ' + $t('words.short_hours') }}
                </option>
            </select>
        </div>

        <button class="w-1/3 bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded-full"
                @click="buyProduct">
            {{ $t('words.buy') }}
        </button>
    </div>
</template>

<style scoped>

</style>
