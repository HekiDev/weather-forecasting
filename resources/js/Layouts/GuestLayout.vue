<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-full">
        <div class="flex items-center justify-center p-9 container">
            <Link href="/" class="text-center text-4xl font-semibold">
                Weather & Forecast Application
            </Link>
        </div>

        <div
            class="container p-5 overflow-hidden flex flex-col gap-3"
        >
            <slot />
        </div>
    </div>
</template>
