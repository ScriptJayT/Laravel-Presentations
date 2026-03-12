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
        class="grow bg-neutral-200 dark:bg-neutral-900 outline-none"
    >
        <slot />
    </main>
</template>