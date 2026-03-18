<script setup lang="ts">
import { SectionHeading, SubSectionHeading } from '.';
withDefaults(
    defineProps<{
        title: string;
        description?: string;
        class?: string;
        semanticLvl?: 2 | 3;
        visualLvl?: 2 | 3;
    }>(),
    {
        semanticLvl: 2,
        visualLvl: 2,
    },
);
</script>

<template>
    <SectionHeading v-if="semanticLvl === 2" :title :description :class />
    <SubSectionHeading
        v-else-if="semanticLvl === 3"
        :title
        :description
        :class
    />
</template>
