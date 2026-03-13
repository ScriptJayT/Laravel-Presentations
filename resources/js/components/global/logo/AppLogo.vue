<script setup lang="ts">
import { AppIcon } from '@/components/global/logo';
import { getAppName } from '@/lib/utils';
</script>

<template>
    <div class="
        grid place-content-center
        size-8 rounded-md
        bg-sidebar-primary
        "
    >
        <AppIcon class="
            size-5
            fill-transparent
            stroke-white dark:stroke-black
            "
        />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">
            {{ getAppName() }}
        </span>
    </div>
</template>
