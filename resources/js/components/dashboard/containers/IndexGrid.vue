<script setup lang="ts">
defineProps<{
    class?: string;
}>();
</script>

<template>
    <div
        data-component="dashboard/containers/IndexGrid"
        :class
        class="grid auto-rows-min gap-x-6 gap-y-12 md:grid-cols-3 lg:grid-cols-4"
    >
        <slot />
    </div>
</template>