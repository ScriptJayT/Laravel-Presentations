<script setup lang="ts">

import { computed } from 'vue';

const props = defineProps<{
    class?: string
}>();
const classList = computed(() => props.class + " test");
</script>

<template>
    <main id="site-content" :class="classList">
        <slot />
    </main>
</template>