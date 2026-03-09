<script setup lang="ts">
withDefaults(
    defineProps<{
        title: string;
        description?: string;
    }>(),
    {}
);
</script>

<template>
    <header data-component="global/text/SubSectionHeading" >
        <h3 class="min-h-lh text-lg font-semibold">
            {{ title }}
        </h3>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
    </header>
</template>
