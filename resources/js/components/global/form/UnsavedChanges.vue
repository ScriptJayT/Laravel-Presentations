<script setup lang="ts">
import { OctagonAlert } from 'lucide-vue-next';

defineProps<{
    hasUnsavedChanges: boolean;
    class?:string;
}>();
</script>

<template>
    <span
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
        <OctagonAlert class="size-4 text-orange-400"/>
        <span> Unsaved Changes </span>
    </span>
</template>