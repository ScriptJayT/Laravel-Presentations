<script setup lang="ts">
import { type Presentation } from '@/types';

import PresentationLink from '@/components/app/PresentationLink.vue';

import Heading from '@/components/Heading.vue';

const props = defineProps<{
    title: string;
    presentations: Array<Presentation>;
    showGuard?: boolean;
}>();

// for some reason, vue's proxy transforms array's to objects; causing issues when trying to get length
const totalPresentations = Array.isArray(props.presentations)
    ? props.presentations.length
    : Object.keys(props.presentations).length
</script>

<template>
    <div data-component="PresentationList" class="p-6 rounded border space-y-4">
        <Heading :title="title" />
        <template v-if="totalPresentations < 1">
            <p class="m-0">None found</p>
        </template>
        <template v-else>
            <span class="block w-fit ml-auto my-0 | italic">
                Showing: {{ totalPresentations }} presentation(s)
            </span>
        </template>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <template v-for="_presentation in presentations">
                <PresentationLink :presentation="_presentation" :show-guard="showGuard ?? false" />
            </template>
        </div>
    </div>
</template>