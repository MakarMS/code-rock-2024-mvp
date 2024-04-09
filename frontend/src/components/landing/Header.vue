<script setup>
import {useI18n} from "vue-i18n";
import 'primeicons/primeicons.css';
import BurgerMenuIcon from "@/components/landing/BurgerMenuIcon.vue";
import {ref} from "vue";
import BurgerMenuSidebar from "@/components/landing/BurgerMenuSidebar.vue";
import {openModal} from "jenesius-vue-modal";
import SignIn from "@/components/landing/modals/SignIn.vue";
import SignUp from "@/components/landing/modals/SignUp.vue";
import router from "@/router.js";
import axios from "@/axios.js";

const {locale, availableLocales} = useI18n();

const isOpen = ref(false);

const toggleSidebar = () => {
    isOpen.value = !isOpen.value;
};

const changeLanguage = () => {
    locale.value = availableLocales[(availableLocales.indexOf(locale.value) + 1) % availableLocales.length];
}

const showModal = (modalName) => {
    const modalComponents = {
        'signInModal': SignIn,
        'signUpModal': SignUp
    };

    const modalComponent = modalComponents[modalName];

    if (modalComponent) {
        openModal(modalComponent);
    }
}

const isAuthenticated = ref(true);
const accountType = localStorage.getItem('account_type');

const checkAuthentication = async () => {
    try {
        if (accountType) {
            axios.post(`/api/user/auth/${accountType}/valid`).then(
                (response) => {
                    isAuthenticated.value = response.status;
                }
            );
        }
    } catch (error) {
        toast.success(t('sentences.success_registration'));
    }
};

router.beforeEach((to, from, next) => {
    checkAuthentication();
    next();
});

checkAuthentication()

</script>

<template>
    <header
        class="fixed top-0 left-0 right-0 z-10 h-16 flex bg-gray-700 bg-opacity-20 backdrop-blur items-center justify-between px-4 py-3 shadow-lg">
        <div class="flex items-center">
            <span class="text-white text-lg font-semibold" title="Easy Route" @click="changeLanguage">Easy Route</span>
        </div>
        <div class="space-x-5">
            <button v-if="!isAuthenticated" v-for="button in $tm('header.buttons')" :title="button.label" @click="showModal(button.modal)"
                    class="rounded-full bg-orange-400 hover:bg-opacity-0 text-white hover:border-orange-400 border-2 border-transparent transition-all px-4 py-2">
                {{ button.label }}
            </button>
            <router-link v-if="isAuthenticated" :to="`/dashboard/${accountType}`" :title="$t('sentences.in_account')">
                <button class="rounded-full bg-orange-400 hover:bg-opacity-0 text-white hover:border-orange-400 border-2 border-transparent transition-all px-4 py-2">
                    {{ $t('words.' + accountType) }}
                </button>
            </router-link>
            <button :title="$t('titles.change_language')" class="relative top-1.5" @click="changeLanguage">
                <i class="pi pi-language text-white hover:text-orange-400 text-2xl"></i>
            </button>
            <BurgerMenuIcon @click="toggleSidebar"/>
        </div>
    </header>
    <BurgerMenuSidebar :isOpen="isOpen"/>
</template>

<style scoped>
</style>
