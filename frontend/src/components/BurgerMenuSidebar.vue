<script setup>
import {defineProps} from 'vue';

defineProps({
    isOpen: Boolean
});

</script>

<template>
    <transition name="fade">
        <aside v-show="isOpen"
               class="fixed top-16 right-0 z-10 w-64 h-full bg-gray-700 bg-opacity-20 backdrop-blur shadow-lg">
            <nav>
                <ul class="text-white font-medium flex flex-col space-y-5 mt-5 ml-10">
                    <li v-for="item in $tm('header.menu_items')" :key="item.id">
                        <a :href="item.url" :title="item.label" class="hover:text-orange-400">{{ item.label }}</a>
                    </li>
                </ul>
            </nav>
        </aside>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.150s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
