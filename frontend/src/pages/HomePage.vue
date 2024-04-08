<script setup>
</script>

<template>
    <main>
        <div id="about" class="relative">
            <img alt="background image" class="w-full object-cover" src="@/assets/home_main_bg_1.jpg">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-white bg-gray-400 bg-opacity-20 backdrop-blur rounded-3xl p-10 w-3/5 mx-auto shadow-lg">
                    <h1 class="text-4xl font-bold">{{ $t('home.main.about.title') }}</h1>
                    <p class="mt-4 text-lg" v-html="$t('home.main.about.text')"></p>
                </div>
            </div>
        </div>
        <div id="services" class="relative">
            <img alt="background image" class="w-full object-cover" src="@/assets/home_main_bg_2.jpg">
            <div class="absolute inset-0 flex justify-center items-center">
                <div class="flex justify-between w-4/5">
                    <div v-for="block in $tm('home.main.services')" class="text-white bg-gray-400 bg-opacity-20 backdrop-blur rounded-3xl p-5 w-80 mx-2 shadow-lg">
                        <h1 class="text-2xl font-bold">{{ block.title }}</h1>
                        <p class="mt-4 text-lg">{{ block.text }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="contacts" class="relative">
            <img alt="background image" class="w-full object-cover" src="@/assets/home_main_bg_3.jpg">
            <div class="absolute inset-0 flex justify-center items-center">
                <div class="flex justify-between w-2/6">
                    <div v-for="block in $tm('home.main.contacts')" class="text-white bg-gray-400 bg-opacity-20 backdrop-blur rounded-3xl p-10 w-80 mx-2 shadow-lg">
                        <h1 class="text-2xl font-bold">{{ block.title }}</h1>
                        <p v-for="contact in block.contacts" class="mt-4 text-lg">{{ contact }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<style scoped>

</style>
