<script setup>
import {ref} from 'vue';

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
</script>

<template>
    <button class="inline text-2xl relative top-1 text-white" @click="toggleMenu">
        <span :class="{ '-rotate-45 relative top-2': isMenuOpen }"
              class="block w-6 h-1 bg-white mb-1 transition ease-linear duration-150"></span>
        <span :class="{ 'opacity-0': isMenuOpen }"
              class="block w-6 h-1 bg-white mb-1 transition ease-linear duration-150"></span>
        <span :class="{ 'rotate-45 relative bottom-2': isMenuOpen }"
              class="block w-6 h-1 bg-white transition ease-linear duration-150"></span>
    </button>
</template>

