<script setup lang="ts">
import { ref } from 'vue';
defineProps<{
    isCurrent: boolean,
    weather: {
        clouds: number,
        date: number,
        feels_like: number,
        temperature: number,
        visibility: number,
        weather_status: string,
        wind_speed: number,
    },
}>();

const cards = ref([
    {text: 'Speed', icon: 'air'},
    {text: 'Visibility', icon: 'visibility'},
    {text: 'Clouds', icon: 'cloud'},
])

const unixToDateTime = (unix: number) => {
    const date = new Date(unix * 1000);
    return date.toLocaleString();
}

const kelvinToFahrenheit = (kelvin: number) => {
    const f = ((kelvin - 273.15) * 9) / 5 + 32;
    return f.toFixed()
}

const kelvinToCelsius = (kelvin: number) => {
    const c = (kelvin - 273.15);
    return c.toFixed()
}
</script>
<template>
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex flex-col flex-1 gap-4 rounded-md p-4 shadow-sm">
            <div class="flex flex-col">
                <h3 class="text-lg text-slate-400">{{ isCurrent ? 'Current Weather' : '' }}</h3>
                <h2 class="text-lg">{{ unixToDateTime($props.weather.date) }}</h2>
            </div>
            <div class="flex flex-col md:flex-row gap-3 items-center">
                <div class="px-5">
                    <span class="pi pi-sun text-3xl text-surface-700"></span>
                </div>
                <h1 class="font-bold text-5xl flex gap-2">
                    {{ kelvinToFahrenheit($props.weather.temperature) }}<span class="text-sm place-self-start">F</span>
                </h1>
                <div class="flex flex-col gap text-center md:text-left">
                    <span>{{ weather.weather_status }}</span>
                    <h2 class="flex gap-1">Feels Like {{ kelvinToCelsius($props.weather.feels_like) }}<span class="text-sm place-self-start">°</span></h2>
                </div>
            </div>
        </div>
        <div class="flex-1">
            <div class="grid grid-cols-[repeat(auto-fill,minmax(200px,_1fr))] h-full gap-3">
                <div 
                    v-for="card, i in cards" 
                    :key="i" 
                    class="flex flex-col gap-3 border border-surface-100 p-5 rounded-md hover:border-surface-400 transition-all dark:text-white max-h-[150px]"
                >
                    <div class="flex gap-3 items-center">
                        <span class="material-symbols-outlined text-surface-700">{{ card.icon }}</span>
                        <p class="text-lg font-semibold">{{ card.text }}</p>
                    </div>
                    <div class="truncate text-ellipsis text-wrap">
                        <h1 class="text-3xl">{{ 
                            card.text == 'Speed' ? `${$props.weather.wind_speed} mps` :
                            card.text == 'Visibility' ? `${$props.weather.visibility} m` :
                            card.text == 'Clouds' ? `${$props.weather.clouds} %` : '' }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>