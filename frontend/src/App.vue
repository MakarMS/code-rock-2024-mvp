<script setup>
import Header from "@/components/landing/Header.vue";
import Footer from "@/components/landing/Footer.vue";
</script>

<template>
    <RouterView/>
    <widget-container-modal/>
</template>

<script>
import {container} from "jenesius-vue-modal";

export default {
    components: {WidgetContainerModal: container},
    name: "App"
}
</script>

<style scoped>
</style>
