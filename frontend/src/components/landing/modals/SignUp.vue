<script setup>
import {ref} from 'vue';
import {closeModal} from 'jenesius-vue-modal';
import {useToast} from 'vue-toastification';
import {useI18n} from "vue-i18n";
import axios from "@/axios.js";
import router from "@/router.js";

const {t} = useI18n();
const toast = useToast();

const firstName = ref('');
const lastName = ref('');
const patronymic = ref('');

const companyName = ref('');
const email = ref('');
const password = ref('');

const accountType = ref('buyer');

const changeAccountType = (type) => {
    accountType.value = type;
    resetAllErrorClasses();
}

const register = () => {
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

        let data = {
            email: email.value,
            password: password.value
        }

        if (accountType.value === 'buyer') {
            data.first_name = firstName.value;
            data.last_name = lastName.value;
            data.patronymic = patronymic.value;
        } else {
            data.company_name = companyName.value;
        }

        axios.post(`/api/user/auth/${accountType.value}/register`, data)
            .then(() => {
                localStorage.setItem('account_type', accountType.value);
                toast.success(t('sentences.success_registration'))
                closeModal();
                router.push(`/${accountType.value}`);
            })
            .catch(error => {
                const authCodes = {
                    1: {selector: 'email', message: t('errors.not_unique_email')}
                };

                if (error.response && error.response.data && error.response.data.code && authCodes[error.response.data.code]) {
                    toast.error(authCodes[error.response.data.code].message);

                    const input = document.getElementById(authCodes[error.response.data.code].selector);

                    addErrorClasses(input);
                    addErrorFocusListener(input);

                } else {
                    console.error(error)
                    toast.error(t('errors.unexpected_error'));
                }
            });
    }
}

const validate = () => {
    const errors = [];

    if (accountType.value === 'buyer') {
        if (!firstName.value.trim()) {
            errors.push({'first_name': t('errors.required_first_name')});
        }

        if (!lastName.value.trim()) {
            errors.push({'last_name': t('errors.required_last_name')});
        }

        if (!patronymic.value.trim()) {
            errors.push({'patronymic': t('errors.required_patronymic')});
        }
    } else if (accountType.value === 'manufacturer') {
        if (!companyName.value.trim()) {
            errors.push({'company_name': t('errors.required_company_name')});
        }
    }

    if (!email.value.trim()) {
        errors.push({'email': t('errors.required_email')});
    } else if (!/\S+@\S+\.\S+/.test(email.value)) {
        errors.push({'email': t('errors.format_email')});
    }

    if (!password.value.trim()) {
        errors.push({'password': t('errors.required_password')});
    } else if (password.value.length < 6) {
        errors.push({'password': t('errors.min_length_password')});
    } else if (password.value.length > 50) {
        errors.push({'password': t('errors.max_length_password')});
    }

    return errors;
}

const resetAllErrorClasses = () => {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.classList.remove('border-red-600', 'focus:ring-red-600');
        input.classList.add('border-gray-300', 'focus:ring-orange-400');
        input.value = '';
    });
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

</script>

<template>
    <div class="bg-white rounded-2xl p-10 w-1/5 relative shadow-lg">
        <button class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-900" @click="closeModal">
            <i class="pi pi-times"></i>
        </button>
        <h2 class="text-2xl font-semibold text-center mb-6">{{ $t('words.sign_up') }}</h2>
        <div class="flex justify-center mb-6">
            <button
                :class="['px-4 py-2 rounded-full font-semibold text-sm mr-2', accountType === 'buyer' ? 'bg-orange-400 text-white' : 'bg-gray-300 text-gray-700']"
                @click="changeAccountType('buyer')"
            >
                {{ $t('words.bayer') }}
            </button>
            <button
                :class="['px-4 py-2 rounded-full font-semibold text-sm ml-2', accountType === 'manufacturer' ? 'bg-orange-400 text-white' : 'bg-gray-300 text-gray-700']"
                @click="changeAccountType('manufacturer')"
            >
                {{ $t('words.manufacturer') }}
            </button>
        </div>
        <div v-if="accountType === 'buyer'" class="mb-6">
            <input id="first_name" v-model="firstName" :placeholder="$t('words.first_name')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div v-if="accountType === 'buyer'" class="mb-6">
            <input id="last_name" v-model="lastName" :placeholder="$t('words.last_name')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div v-if="accountType === 'buyer'" class="mb-6">
            <input id="patronymic" v-model="patronymic" :placeholder="$t('words.patronymic')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div v-if="accountType === 'manufacturer'" class="mb-6">
            <input id="company_name" v-model="companyName" :placeholder="$t('words.company_name')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div class="mb-6">
            <input id="email" v-model="email" :placeholder="$t('words.email')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="email">
        </div>
        <div class="mb-6">
            <input id="password" v-model="password" :placeholder="$t('words.password')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="password">
        </div>
        <button class="w-full bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded-full" @click="register">
            {{ $t('words.sign_up') }}
        </button>
    </div>
</template>

<style scoped>
</style>
