<script setup lang="ts">
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
            block w-max p-2
            border border-orange-400 rounded-md
            text-sm
            bg-background
            "
    >
        Unsaved Changes
    </span>
</template>