<script setup>
import { OctagonAlert } from 'lucide-vue-next';
import AsideZone from './AsideZone.vue';
</script>

<template>
    <AsideZone class="border-red-900">
        <h3 class="flex items-center gap-3 text-lg font-semibold text-red-900">
            <OctagonAlert class="size-5"/>
            <span> Danger zone </span>
        </h3>
        <slot/>
    </AsideZone>
</template>