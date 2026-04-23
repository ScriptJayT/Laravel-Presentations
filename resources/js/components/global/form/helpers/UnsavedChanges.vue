<script setup lang="ts">
import { OctagonAlert } from '@lucide/vue';
defineProps<{
    hasUnsavedChanges: boolean;
    class?:string;
}>();
</script>

<template>
    <span
        data-component="global/form/UnsavedChanges"
        v-show="hasUnsavedChanges"
        aria-live="polite"
        :class
        class="
            flex gap-1 items-center w-max p-2
            border border-orange-400 rounded-md
            text-sm
            bg-background animate-pulse
            "
    >
        <span aria-hidden="true">
            <OctagonAlert class="size-4 text-orange-400" />
        </span>
        <span> Unsaved Changes </span>
    </span>
</template>