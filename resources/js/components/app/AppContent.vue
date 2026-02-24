<script setup lang="ts">
defineProps<{
    class?: string
}>();
</script>

<template>
    <main
        id="site-content"
        :class
        class="bg-gray-200 dark:bg-gray-900"
    >
        <slot />
    </main>
</template>