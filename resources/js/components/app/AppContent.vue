<script setup lang="ts">
defineProps<{
    class?: string
}>();
</script>

<template>
    <main
        id="site-content"
        tabindex="-1"
        :class
        class="grow bg-background outline-none"
    >
        <slot />
    </main>
</template>