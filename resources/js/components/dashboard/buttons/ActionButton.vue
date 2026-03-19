<script setup lang="ts">
import { cn } from '@/lib/utils';
import { actionButtonClasses } from '.';
const props = defineProps<{
    text?: string;
    class?: string;
    onClick?: () => void;
}>();
function handleClick() {
    props.onClick?.();
}
</script>

<template>
    <button
        v-on:click="handleClick"
        :class="cn(actionButtonClasses(), props.class)"
        type="button"
    >
        {{ text }}
        <slot />
    </button>
</template>