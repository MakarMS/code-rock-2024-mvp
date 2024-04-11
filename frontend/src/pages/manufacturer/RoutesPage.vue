<script setup>
import Header from '../../components/manufacturer/Header.vue';
import {openModal} from "jenesius-vue-modal";
import CreateEditRoute from "@/components/manufacturer/modals/CreateEditRoute.vue";
</script>

<template>
    <Header/>
    <main class="text-orange-400 w-12/12 h-full shadow-lg m-10 rounded-lg p-5">
        <button
            class="font-semibold border-gray-200 px-4 py-2 rounded-full hover:border-orange-400 border-2 transition-all mb-5"
            @click="openModal(CreateEditRoute)">
            {{ $t('words.create') }}
        </button>
        <hr>
        <div>
            <table class="w-full mt-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ $t('sentences.departure_point') }}</th>
                    <th>{{ $t('sentences.arrival_point') }}</th>
                    <th>{{ $t('words.cost') }}</th>
                    <th>{{ $t('sentences.length_delivery') }}</th>
                    <th>{{ $t('words.distance') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </main>
</template>

<style scoped>

</style>

