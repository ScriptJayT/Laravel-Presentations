<script setup lang="ts">
import { cn } from '@/lib/utils';
import { actionButtonClasses } from '.';
const props = defineProps<{
    url: string;
    text?: string;
    class?: string;
}>();
</script>

<template>
    <a :href="url" :class="cn(props.class, actionButtonClasses())">
        {{ text }}
        <slot />
    </a>
</template>
