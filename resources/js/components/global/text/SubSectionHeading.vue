<script setup lang="ts">
defineProps<{
    title: string;
    description?: string;
    class?: string;
}>();
</script>

<template>
    <header
        data-component="global/text/SubSectionHeading"
        :class
    >
        <h3 class="min-h-lh text-lg font-semibold">
            {{ title }}
        </h3>
        <p
            v-if="description"
            class="text-sm text-muted-foreground"
        >
            {{ description }}
        </p>
    </header>
</template>
