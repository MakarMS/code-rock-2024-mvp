<script setup>

import {closeModal} from "jenesius-vue-modal";
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

async function fetchProduct() {
    if (props.id !== 0) {
        try {
            const response = await axios.get(`/api/manufacturer/product/${props.id}`);

            product.value.product_name = response.data.product_name;
            product.value.cost = response.data.cost;
            product.value.height = response.data.height;
            product.value.width = response.data.width;
            product.value.depth = response.data.depth;
            product.value.mass = response.data.mass;

            product.value.description = response.data.description;
            product.value.image = 'http://api.localhost/storage/' + response.data.image;

        } catch (error) {
            toast.error(t('errors.unexpected_error'))
        }
    }
}

const product = ref({
    product_name: '',
    description: '',
    image: 'http://api.localhost/storage/products/images/image-stub.jpg',
    cost: 0,
    height: 0,
    width: 0,
    depth: 0,
    mass: 0
});

const uploadedFile = ref('');

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

    let url = '/api/manufacturer/product';

    if (props.id !== 0) {
        url = `/api/manufacturer/product/${props.id}`
    }

    if (!errors.length) {
        const formData = new FormData();

        formData.append('product_name', product.value.product_name);
        formData.append('description', product.value.description);
        formData.append('cost', product.value.cost);
        formData.append('height', product.value.height);
        formData.append('width', product.value.width);
        formData.append('depth', product.value.depth);
        formData.append('mass', product.value.mass);

        if (uploadedFile.value) {
            formData.append('image', uploadedFile.value);
        }

        axios.post(url, formData)
            .then(() => {
                if (props.id !== 0) {
                    toast.success(t('sentences.product_edited'));
                } else {
                    toast.success(t('sentences.product_created'));
                }

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

    if (product.value.product_name === '') {
        errors.push({'product_name': t('errors.required_product_name')});
    }

    if (product.value.description === '') {
        errors.push({'description': t('errors.required_description')});
    }

    const costValue = Number(product.value.cost);
    if (isNaN(costValue) || costValue < 0) {
        errors.push({'cost': t('errors.wrong_cost')});
    }

    const height = Number(product.value.height);
    if (isNaN(height) || height < 0) {
        errors.push({'height': t('errors.required_height')});
    }

    const width = Number(product.value.width);
    if (isNaN(width) || width < 0) {
        errors.push({'width': t('errors.required_width')});
    }

    const depth = Number(product.value.depth);
    if (isNaN(depth) || depth < 0) {
        errors.push({'depth': t('errors.required_depth')});
    }

    const mass = Number(product.value.mass);
    if (isNaN(mass) || mass < 0) {
        errors.push({'mass': t('errors.required_mass')});
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

const previewImage = (event) => {
    const file = uploadedFile.value = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            product.value.image = e.target.result;
        };

        reader.readAsDataURL(file);
    }
}

onMounted(() => {
    fetchProduct();
})
</script>

<template>
    <div class="bg-white rounded-2xl p-10 w-2/5 relative shadow-lg mix-h-5/12">
        <button class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-900" @click="closeModal">
            <i class="pi pi-times"></i>
        </button>
        <h2 v-if="props.id !== 0" class="text-2xl font-semibold text-left mb-6">{{
                $t('sentences.editing_product')
            }}</h2>
        <h2 v-if="props.id === 0" class="text-2xl font-semibold text-left mb-6">{{
                $t('sentences.creating_product')
            }}</h2>
        <div class="flex justify-between mb-5">
            <div class="flex flex-col justify-between">
                <img :src="product.image" alt="" width="300px"/>
                <input id="image" class="mt-5" type="file" @change="previewImage">
            </div>
            <div class="flex flex-col">
                <div class="flex flex-col w-64">
                    <label class="block" for="product_name">{{ $t('sentences.product_name') }}</label>
                    <input id="product_name" v-model="product.product_name"
                           class="text-center px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                           list="cost" type="text">
                </div>
                <div class="flex flex-col w-64 mt-5">
                    <label class="block" for="cost">{{ $t('words.cost') }} (₽) </label>
                    <input id="cost" v-model="product.cost"
                           class="text-center px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                           type="text">
                </div>
                <div class="flex">
                    <div class="flex flex-col w-20 mt-5">
                        <label class="block text-center" for="height">{{ $t('words.height') }} ({{
                                $t('words.m')
                            }}) </label>
                        <input id="height" v-model="product.height"
                               class="text-center mr-1 ml-1 px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                               type="text">
                    </div>
                    <div class="flex flex-col w-20 mt-5">
                        <label class="block text-center" for="width">{{ $t('words.width') }} ({{
                                $t('words.m')
                            }}) </label>
                        <input id="width" v-model="product.width"
                               class="text-center mr-1 ml-1 px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                               type="text">
                    </div>
                    <div class="flex flex-col w-20 mt-5">
                        <label class="block text-center" for="depth">{{ $t('words.depth') }} ({{
                                $t('words.m')
                            }}) </label>
                        <input id="depth" v-model="product.depth"
                               class="text-center mr-1 ml-1 px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                               type="text">
                    </div>
                </div>
                <div class="flex flex-col w-64 mt-5">
                    <label class="block" for="mass">{{ $t('words.mass') }} ({{ $t('words.short_kg') }}) </label>
                    <input id="mass" v-model="product.mass"
                           class="text-center px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                           type="text">
                </div>
            </div>
        </div>
        <div class="flex flex-col mb-5 h-32">
            <label class="block" for="description">{{ $t('words.description') }}</label>
            <textarea id="description" v-model="product.description"
                      class="w-full h-32 resize-none border border-orange-400 p-2 rounded-md"></textarea>
        </div>
        <button class="w-1/3 bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded-full" @click="create">
            {{ $t('words.save') }}
        </button>
    </div>
</template>

<style scoped>

</style>
