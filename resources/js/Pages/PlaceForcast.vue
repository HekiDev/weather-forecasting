<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Button from 'primevue/button';
import Forecast from '@/Components/Forecast.vue';

defineProps<{
    place: any,
    forecasts: any,
}>();

const handleBack = () => {
    router.get(route('home.index'))
}
</script>

<template>
    <GuestLayout>
        <div class="flex flex-col gap-3 shadow-sm p-5 items-center">
            <Button icon="pi pi-arrow-left" label="Back" class="md:px-5 py-3" @click="handleBack"/>
            <h1 class="text-4xl">{{ $props.place.name }}</h1>
            <p>{{ $props.place.location.formatted_address }}</p>
        </div>
        <div class="flex flex-col gap-5">
            <h1 class="text-xl font-semibold">Weather Forecasts</h1>
            <Forecast
                v-for="forecast, i in $props.forecasts.data"
                :key="i"
                :weather="forecast" 
                :isCurrent="false"
            />
        </div>
    </GuestLayout>
</template>
