<script setup>
import {useI18n} from "vue-i18n";

const {locale, availableLocales} = useI18n();

const changeLanguage = () => {
    locale.value = availableLocales[(availableLocales.indexOf(locale.value) + 1) % availableLocales.length];
}
</script>
<template>
    <header class="bg-white text-orange-400 p-4 flex justify-between items-center shadow-lg">
        <div>
            <router-link v-for="button in $tm('header.manufacturer_header')" :title="button.label" :to="'/manufacturer/' + button.route" class="font-semibold px-4 py-2 rounded-full hover:border-orange-400 border-2 border-transparent transition-all">
                {{ button.label }}
            </router-link>
        </div>
        <button :title="$t('titles.change_language')" class="relative" @click="changeLanguage">
            <i class="pi pi-language text-orange-400 hover:text-orange-500 text-2xl"></i>
        </button>
    </header>
</template>

<style scoped>
</style>
