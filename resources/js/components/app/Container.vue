<script setup lang="ts">
const props = defineProps<{
    class?: string
}>();
</script>

<template>
    <div data-component="Container" class="relative isolate max-w-6xl mx-auto px-4" :class>
        <slot />
    </div>
</template>

<style scoped>
    div {
        container-type: inline-size;
    }
</style>