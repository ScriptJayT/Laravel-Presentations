<script setup lang="ts">
import { Spinner } from '@/components/ui/spinner';
defineProps<{
    isInProcess: boolean;
    class?: string;
}>();
</script>

<template>
    <span
        data-component="global/form/ProcessIndicator"
        aria-live="polite"
        :class
        class="block"
        v-show="isInProcess"
    >
        <Spinner />
    </span>
</template>
