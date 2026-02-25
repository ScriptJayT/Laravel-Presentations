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
        class="bg-gray-200 dark:bg-gray-900 outline-none"
    >
        <slot />
    </main>
</template>