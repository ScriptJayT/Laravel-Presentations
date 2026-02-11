<script setup lang="ts">
</script>

<template>
    <div data-component="Container" class="max-w-5xl mx-auto px-4">
        <slot />
    </div>
</template>

<style scoped>
    div {
        container-type: inline-size;
        position: relative;
        isolation: isolate;
    }
</style>