<script setup>
import {useI18n} from "vue-i18n";
import axios from "@/axios.js";
import router from "@/router.js";
import {useToast} from "vue-toastification";

const {locale, availableLocales} = useI18n();

const {t} = useI18n();
const toast = useToast();

const changeLanguage = () => {
    locale.value = availableLocales[(availableLocales.indexOf(locale.value) + 1) % availableLocales.length];
}

const logout = () => {
    axios.post('/api/user/auth/buyer/logout').then(() => {
        toast.success(t('sentences.logout'));
        router.push('/');
    }).catch(error => {
        console.error(error)
        toast.error(t('errors.unexpected_error'));
    })
}

</script>
<template>
    <header class="bg-white text-orange-400 p-4 flex justify-between items-center shadow-lg">
        <div>
            <router-link v-for="button in $tm('header.buyer_header')" :title="button.label"
                         :to="button.route" active-class="border-orange-400"
                         class="border-gray-200 font-semibold px-4 py-2 rounded-full hover:border-orange-400 border-2 transition-all ml-5">
                {{ button.label }}
            </router-link>
        </div>
        <div class="flex justify-center">
            <button :title="$t('titles.change_language')" class="relative" @click="changeLanguage">
                <i class="pi pi-language text-orange-400 hover:text-orange-500 text-2xl"></i>
            </button>
            <button
                :title="$t('words.logout')"
                class="font-semibold px-4 py-2 rounded-full hover:border-orange-400 border-2 border-transparent transition-all ml-5" @click="logout">
                {{ $t('words.logout') }}
            </button>
        </div>
    </header>
</template>

<style scoped>
</style>
