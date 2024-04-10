<script setup>

import Header from '../../components/manufacturer/Header.vue';
</script>

<template>
    <Header />
    <div class="grid grid-cols-1 md:grid-cols-2 shadow-lg lg:grid-cols-4 gap-4 mt-10 ml-5 mr-5">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Total Sales</h2>
            <p class="text-3xl font-bold text-orange-400">10,000 ₽</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Total Orders</h2>
            <p class="text-3xl font-bold text-orange-400">100</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-4">New Customers</h2>
            <p class="text-3xl font-bold text-orange-400">50</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Pending Orders</h2>
            <p class="text-3xl font-bold text-orange-400">10</p>
        </div>
    </div>
    <div class="mt-10 ml-5 mr-5">
        <h2 class="text-xl font-semibold mb-4">Most Popular Products</h2>
        <ul>
            <li class="flex items-center justify-between bg-white rounded-lg shadow-md p-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Product 1</h3>
                    <p class="text-sm">Category: Category 1</p>
                </div>
                <span class="text-lg font-bold text-orange-400">1000 ₽</span>
            </li>
            <li class="flex items-center justify-between bg-white rounded-lg shadow-md p-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Product 2</h3>
                    <p class="text-sm">Category: Category 2</p>
                </div>
                <span class="text-lg font-bold text-orange-400">900 ₽</span>
            </li>
            <li class="flex items-center justify-between bg-white rounded-lg shadow-md p-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Product 3</h3>
                    <p class="text-sm">Category: Category 3</p>
                </div>
                <span class="text-lg font-bold text-orange-400">800 ₽</span>
            </li>
            <li class="flex items-center justify-between bg-white rounded-lg shadow-md p-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Product 4</h3>
                    <p class="text-sm">Category: Category 4</p>
                </div>
                <span class="text-lg font-bold text-orange-400">700 ₽</span>
            </li>
            <li class="flex items-center justify-between bg-white rounded-lg shadow-md p-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Product 5</h3>
                    <p class="text-sm">Category: Category 5</p>
                </div>
                <span class="text-lg font-bold text-orange-400">600 ₽</span>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>

