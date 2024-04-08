<template>
    <div class="bg-white rounded-2xl p-10 w-1/5 relative shadow-lg">
        <button class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-900" @click="closeModal">
            <i class="pi pi-times"></i>
        </button>
        <h2 class="text-2xl font-semibold text-center mb-6">{{ $t('words.sign_up') }}</h2>
        <div class="flex justify-center mb-6">
            <button
                :class="['px-4 py-2 rounded-full font-semibold text-sm mr-2', accountType === 'buyer' ? 'bg-orange-400 text-white' : 'bg-gray-300 text-gray-700']"
                @click="accountType = 'buyer'"
            >
                {{ $t('words.bayer') }}
            </button>
            <button
                :class="['px-4 py-2 rounded-full font-semibold text-sm ml-2', accountType === 'producer' ? 'bg-orange-400 text-white' : 'bg-gray-300 text-gray-700']"
                @click="accountType = 'producer'"
            >
                {{ $t('words.maker') }}
            </button>
        </div>
        <div v-if="accountType === 'buyer'" class="mb-6">
            <input v-model="firstName" :placeholder="$t('words.first_name')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div v-if="accountType === 'buyer'" class="mb-6">
            <input v-model="lastName" :placeholder="$t('words.last_name')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div v-if="accountType === 'buyer'" class="mb-6">
            <input v-model="patronymic" :placeholder="$t('words.patronymic')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div v-if="accountType === 'buyer'" class="mb-6">
            <input v-model="email" :placeholder="$t('words.email')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="email">
        </div>
        <div v-if="accountType === 'producer'" class="mb-6">
            <input v-model="companyName" :placeholder="$t('words.company_name')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="text">
        </div>
        <div class="mb-6">
            <input v-model="password" :placeholder="$t('words.password')"
                   class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400"
                   type="password">
        </div>
        <button class="w-full bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 rounded" type="submit">
            {{ $t('words.sign_up') }}
        </button>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import {closeModal} from 'jenesius-vue-modal';

const firstName = ref('');
const lastName = ref('');
const patronymic = ref('');
const companyName = ref('');
const email = ref('');
const password = ref('');
const accountType = ref('buyer');

</script>

<style scoped>
</style>
