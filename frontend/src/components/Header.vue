<script setup>
import {useI18n} from "vue-i18n";
import 'primeicons/primeicons.css';
import BurgerMenuIcon from "@/components/BurgerMenuIcon.vue";
import {ref} from "vue";
import BurgerMenuSidebar from "@/components/BurgerMenuSidebar.vue";

const {locale, availableLocales} = useI18n();

const isOpen = ref(false);

const toggleSidebar = () => {
    isOpen.value = !isOpen.value;
};

const changeLanguage = () => {
    locale.value = availableLocales[(availableLocales.indexOf(locale.value) + 1) % availableLocales.length];
}
</script>

<template>
    <header
        class="fixed top-0 left-0 right-0 z-10 h-16 flex bg-gray-700 bg-opacity-20 backdrop-blur items-center justify-between px-4 py-3 shadow-lg">
        <div class="flex items-center">
            <span class="text-white text-lg font-semibold" title="Easy Route" @click="changeLanguage">Easy Route</span>
        </div>
        <div class="space-x-5">
            <button v-for="button in $tm('header.buttons')" :title="button.label"
                    class="rounded-full bg-orange-400 hover:bg-opacity-0 text-white hover:border-orange-400 border-2 border-transparent transition-all px-4 py-2">
                {{ button.label }}
            </button>
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
