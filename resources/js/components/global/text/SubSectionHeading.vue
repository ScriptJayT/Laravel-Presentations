<script setup lang="ts">
import type { FunctionalComponent } from 'vue';
import { SubSectionHeadingClasses } from '.';
import { cn } from '@/lib/utils';
const props = defineProps<{
    title: string;
    description?: string;
    class?: string;
    icon?: FunctionalComponent
}>();
</script>

<template>
    <header
        data-component="global/text/SubSectionHeading"
        :class
    >
        <h3
            :class="cn(
                ['flex', 'items-center', 'gap-x-3', 'min-h-lh'],
                SubSectionHeadingClasses(),
            )"
        >
            <component
                v-if="icon"
                :is="icon"
                class="size-5"
            />
            <span> {{ title }} </span>
        </h3>
        <p
            v-if="description"
            class="text-sm text-muted-foreground"
        >
            {{ description }}
        </p>
    </header>
</template>
