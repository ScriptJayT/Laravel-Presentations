<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/global/AppLogoIcon.vue';
const appName = usePage().props.appName as string;
</script>

<template>
    <div
        class="
            flex items-center justify-center
            size-8 aspect-square
            rounded-md
            text-sidebar-primary-foreground
            bg-sidebar-primary
            "
    >
        <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">
            {{ appName }}
        </span>
    </div>
</template>
