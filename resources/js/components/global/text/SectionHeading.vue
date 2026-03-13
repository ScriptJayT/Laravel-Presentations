<script setup lang="ts">
import { cn } from '@/lib/utils';
import { SectionHeadingClasses } from '.';
const props = withDefaults(
    defineProps<{
        title: string;
        description?: string;
        class?: string;
        variant?: 'default' | 'small';
    }>(),
    {
        class: '',
        variant: 'default',
    }
);
</script>

<template>
    <header
        data-component="global/text/SectionHeading"
        :class="cn(
            variant === 'small'
                ? ''
                : 'mb-8 space-y-0.5',
            props.class
        )"
    >
        <h2
            :class="cn(
                variant === 'small'
                    ? 'mb-0.5 text-base font-medium'
                    : SectionHeadingClasses(),
                'min-h-lh'
            )"
        >
            {{ title }}
        </h2>
        <p
            v-if="description"
            class="text-sm text-muted-foreground"
        >
            {{ description }}
        </p>
    </header>
</template>
