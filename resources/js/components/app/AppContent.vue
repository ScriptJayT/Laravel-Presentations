<script setup lang="ts">

import { computed } from 'vue';

const props = defineProps<{
    class?: string
}>();

const className = computed(() => props.class);

</script>

<template>
    <main id="site-content" :class="className">
        <slot />
    </main>
</template>