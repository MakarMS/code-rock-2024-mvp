<script setup>
const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-orange-400 text-white py-10">
        <div class="container mx-auto">
            <div class="text-center mt-5">
                &copy; {{ currentYear + ' ' + $t('copyright')}}
            </div>
        </div>
    </footer>
</template>

<style scoped>
</style>
