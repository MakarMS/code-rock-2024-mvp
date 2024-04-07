<script setup>
</script>

<template>
    <main>
        <div class="relative">
            <img alt="background image" class="w-full object-cover" src="@/assets/home_main_bg.jpg">
            <div class="absolute inset-0 flex items-center justify-center">
                <div
                    class="text-white bg-gray-400 bg-opacity-20 backdrop-blur rounded-3xl p-10  sm:w-11/12 md:w-2/3 lg:w-1/2 mx-auto shadow-lg">
                    <h1 class="text-4xl font-bold">{{ $t('home.main.main_title') }}</h1>
                    <p class="mt-4 text-lg">{{ $t('home.main.main_text') }}</p>
                </div>
            </div>
        </div>
    </main>
</template>


