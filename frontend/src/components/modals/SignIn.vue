<script setup>
import {ref} from 'vue';
import {closeModal} from 'jenesius-vue-modal';
import {useI18n} from "vue-i18n";
import {useToast} from "vue-toastification";

import axios from "@/axios.js";
import router from "@/router.js";

const {t} = useI18n();

const email = ref('');
const password = ref('');
const rememberMe = ref(false);
const accountType = ref('buyer');

const changeAccountType = (type) => {
    accountType.value = type;
    resetAllErrorClasses();
}

const login = () => {
    const errors = validate();
    const toast = useToast();

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
            password: password.value,
            remember_me: rememberMe.value,
        }

        axios.post(`/api/user/auth/${accountType.value}/login`, data)
            .then(() => {
                localStorage.setItem('account_type', accountType.value);
                toast.success(t('sentences.success_login'));
                setTimeout(() => {
                    router.push(`/${accountType.value}`);
                }, 2000);
            })
            .catch(error => {
                const authCodes = {
                    2: t('errors.wrong_login')
                };

                if (error.response && error.response.data && error.response.data.code && authCodes[error.response.data.code]) {
                    toast.error(authCodes[error.response.data.code]);

                    document.querySelectorAll('input').forEach(input => {
                        addErrorClasses(input);
                        addErrorFocusListener(input);
                    });

                } else {
                    console.error(error)
                    toast.error(t('errors.unexpected_error'));
                }
            });
    }
}

const validate = () => {
    const errors = [];

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
        <h2 class="text-2xl font-semibold text-center mb-6">{{ $t('words.sign_in') }}</h2>
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
        <div class="mb-6">
            <input v-model="email" :placeholder="$t('words.email')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="email">
        </div>
        <div class="mb-6">
            <input v-model="password" :placeholder="$t('words.password')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="password">
        </div>
        <label class="flex items-center mb-6">
            <input v-model="rememberMe" class="form-checkbox h-5 w-5 text-orange-400" type="checkbox">
            <span class="ml-2 text-gray-700">{{ $t('words.remember_password') }}</span>
        </label>
        <button class="w-full bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded-full" @click="login">
            {{ $t('words.to_sign_in') }}
        </button>
    </div>
</template>

<style scoped>
</style>
