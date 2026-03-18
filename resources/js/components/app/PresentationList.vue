<script setup lang="ts">
import { type Presentation } from '@/types';
import { plural, cn } from '@/lib/utils';
import { SectionHeadingClasses } from '../global/text';
import PresentationLink from '@/components/app/PresentationLink.vue';
import { FunctionalComponent } from 'vue';
const props = withDefaults(
    defineProps<{
        title: string;
        presentations: Array<Presentation>;
        showGuard?: boolean;
        showUser?: boolean;
        class?: string;
        icon?: FunctionalComponent;
    }>(),
    {
        showGuard: false,
        showUser: true,
    },
);
</script>

<template>
    <section
        data-component="app/PresentationList"
        :class="
            cn(
                props.class,
                ['space-y-4'],
                ['rounded-4xl', 'border-3', 'bg-card'],
                ['px-5', 'md:px-6', 'lg:px-8'],
                ['pt-5', 'md:pt-6', 'lg:pt-8'],
                ['pb-6', 'md:pb-8', 'lg:pb-10'],
                [
                    'shadow-lg',
                    'shadow-gray-500',
                    'dark:shadow-md',
                    'dark:shadow-gray-400',
                ],
            )
        "
    >
        <header class="mb-10 flex flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <span v-if="icon" class="hidden sm:block shrink-0">
                    <component :is="icon" class="size-6 md:size-7" />
                </span>
                <h2 :class="SectionHeadingClasses()">
                    {{ title }}
                </h2>
            </div>
            <span class="my-0 ml-auto block min-w-fit italic">
                {{ plural(presentations, 'presentation') }} found
            </span>
        </header>
        <div
            class="grid auto-rows-min gap-x-10 gap-y-12 sm:grid-cols-2 lg:grid-cols-3"
        >
            <template v-for="_presentation in presentations">
                <PresentationLink
                    :presentation="_presentation"
                    :show-guard="showGuard"
                    :show-user="showUser"
                />
            </template>
        </div>
    </section>
</template>
