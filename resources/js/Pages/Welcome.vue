<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Button from 'primevue/button';
import Select from 'primevue/select';
import Chip from 'primevue/chip';

import Forecast from '@/Components/Forecast.vue';

defineProps<{
    places: any,
    currentWeather: {
        data: {
            clouds: number,
            date: number,
            feels_like: number,
            temperature: number,
            visibility: number,
            weather_status: string,
            wind_speed: number,
        }
    },
}>();

const query = ref();
const near = ref('Tokyo')
const cities = ref([
    { name: 'Tokyo', code: 'Tokyo' },
    { name: 'Yokohama', code: 'Yokohama' },
    { name: 'Kyoto', code: 'Kyoto' },
    { name: 'Osaka', code: 'Osaka' },
    { name: 'Sapporo', code: 'Sapporo' },
    { name: 'Nagoya', code: 'Nagoya' },
]);

const search = (event: any) => {
    setTimeout(() => {
        router.get(route('home.index'), {
            query: query.value,
            near: near.value,
        }, { preserveState: true })
    }, 250);
}

const convertToKm = (meters: number) => {
    return (meters / 1000).toFixed(2);
}
</script>

<template>
    <GuestLayout>
        <div class="flex flex-col md:flex-row gap-2 items-center">
            <IconField class="w-full">
                <InputIcon class="pi pi-search" />
                <InputText 
                    :placeholder="`Search place you want to visit near ${near}`" 
                    class="w-full" 
                    size="large" 
                    v-model="query" 
                />
            </IconField>
            <Select 
                v-model="near" 
                :options="cities" 
                optionLabel="name" 
                optionValue="code" 
                checkmark 
                :highlightOnSelect="false"
                dropdownIcon="pi pi-map-marker"
                class="w-full md:w-56" 
            />
            <Button icon="pi pi-search" class="w-full md:w-auto md:px-10 py-3" @click="search"/>
        </div>
        <div class="">
            <Forecast
                :weather="currentWeather.data" 
                :isCurrent="true"
            />
        </div>
        <h1 class="py-10 flex items-center gap-2 flex-wrap">
            Places Near <span class="font-bold"><Chip :label="near" icon="pi pi-map-marker" /></span>
        </h1>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,_1fr))] h-full gap-3"
            v-if="$props.places.data.length > 0"
        >
            <Link
                class="flex flex-col gap-3 border border-surface-100 p-5 rounded-md hover:border-surface-400 transition-all dark:text-white min-h-[150px] cursor-pointer" 
                v-for="place, i in $props.places.data" :key="i"
                :href="route('home.forecast', place.fsq_id)"
            >
                <div class="flex gap-3 items-center">
                    <span class="pi pi-map"></span>
                    <p class="text-lg font-semibold">{{ place.name }}</p>
                </div>
                <div class="text-wrap flex-1">
                    {{ place.location.formatted_address }}
                </div>
                <span class="text-gray-500 text-sm">{{ convertToKm(place.distance) }} Km</span>
                <div class="">
                    <ul class="flex flex-wrap gap-2">
                        <li v-for="category, in place.categories" :key="i">
                            <Chip :label="category.name" class="px-0 py-0 text-sm"/>
                        </li>
                    </ul>
                </div>
            </Link>
        </div>
        <div class="text-center" v-else>No resuls found.</div>
    </GuestLayout>
</template>
