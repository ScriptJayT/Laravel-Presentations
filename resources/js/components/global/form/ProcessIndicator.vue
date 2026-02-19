<script setup lang="ts">
import { Spinner } from '@/components/ui/spinner';

defineProps<{
    isInProcess: boolean;
    class?: string;
}>();
</script>

<template>
    <span :class>
        <Spinner v-show="isInProcess"/>
    </span>
</template>
