<script setup lang="ts">
import { type Presentation } from '@/types';
import PresentationLink from '@/components/app/PresentationLink.vue';
import Heading from '@/components/Heading.vue';

const props = withDefaults(
    defineProps<{
        title: string;
        presentations: Array<Presentation>;
        showGuard?: boolean;
        showUser?: boolean;
        class?: string;
    }>(),
    {
        showGuard: false,
        showUser: true,
    }
);
const totalPresentations = Array.isArray(props.presentations)
    ? props.presentations.length
    : Object.keys(props.presentations).length
</script>

<template>
    <section
        data-component="app/PresentationList"
        :class
        class="p-6 rounded border-2 space-y-4"
    >
        <header class="flex gap-4 justify-between flex-wrap">
            <Heading :title />
            <template v-if="totalPresentations < 1">
                <p class="m-0 min-w-fit">None found</p>
            </template>
            <template v-else>
                <span class="block min-w-fit ml-auto my-0 | italic">
                    Showing: {{ totalPresentations }} presentation(s)
                </span>
            </template>
        </header>
        <div class="grid auto-rows-min gap-x-10 gap-y-12 md:grid-cols-3">
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