<script setup>

const props = defineProps({
    order: {type: Object}
});

</script>

<template>
    <div class="flex m-10 shadow-lg p-5 rounded-xl w-8/12">
        <img :src="'http://api.localhost' + props.order.image" alt="" class="mb-5" width="300px">
        <div class="ml-5">
            <p class="text-orange-500 mb-2">{{ $t('words.name') }}: {{ props.order.product_name }}</p>
            <p class="text-orange-500 mb-2">{{ $t('words.manufacturer') }}: {{ props.order.manufacturer }}</p>
            <p class="text-orange-500 mb-2">{{ $t('words.quantity') }}: {{ props.order.count }} ({{
                    $t('words.pcs')
                }})</p>
            <p class="text-orange-500 mb-2">{{ $t('words.cost') }}: {{ props.order.cost }} (₽)</p>
        </div>
        <div class="ml-48">
            <p class="text-orange-500 mb-2">{{ $t('words.routes') }}:</p>
            <p v-for="route in props.order.routes" class="text-orange-500 ml-10 mb-2">
                {{ route.departure_point + ' -> ' + route.arrival_point }}</p>
        </div>
    </div>
</template>

<style scoped>

</style>
