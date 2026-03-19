<script setup>
import { OctagonAlert } from 'lucide-vue-next';
import { SubSectionHeading } from '@/components/global/text';
import AsideZone from './AsideZone.vue';
</script>

<template>
    <AsideZone class="border-red-900 dark:border-red-300">
        <SubSectionHeading
            title="Danger zone"
            class=" text-red-900 dark:text-red-300"
            :icon="OctagonAlert"
        />
        <slot/>
    </AsideZone>
</template>