<script setup lang="ts">

import { computed } from 'vue';

const props = defineProps<{
    class?: string
}>();
const classList = computed(() => props.class);
</script>

<template>
    <main id="site-content" :class="classList" class="">
        <slot />
    </main>
</template>