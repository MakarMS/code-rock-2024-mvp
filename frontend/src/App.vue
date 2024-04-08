<script setup>
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";
</script>

<template>
    <Header/>
    <RouterView/>
    <Footer/>
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
