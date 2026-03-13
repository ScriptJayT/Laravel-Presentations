<script setup lang="ts">
import AppLogoIcon from '@/components/global/AppLogoIcon.vue';
import { getAppName } from '@/lib/utils';
</script>

<template>
    <div class="
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
            {{ getAppName() }}
        </span>
    </div>
</template>
