<script setup>
const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="flex justify-center items-center bg-orange-400 text-white py-5">
        &copy; {{ currentYear + ' ' + $t('sentences.copyright') }}
    </footer>
</template>

<style scoped>
</style>
