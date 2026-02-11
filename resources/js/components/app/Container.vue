<script setup lang="ts">

import { computed } from 'vue';

const props = defineProps<{
    class?: string
}>();
const classList = computed(() => props.class + " relative isolate max-w-5xl mx-auto px-4");
</script>

<template>
    <div data-component="Container" :class="classList">
        <slot />
    </div>
</template>

<style scoped>
    div {
        container-type: inline-size;
    }
</style>